<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Display chat list and conversation with selected user.
     */
    public function index(?User $user = null): View
    {
        if ($user && $user->role !== 'user') {
            abort(404);
        }

        $chatUsers = User::where('role', 'user')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $selectedUser = $user;
        if (! $selectedUser && $chatUsers->isNotEmpty()) {
            $selectedUser = $chatUsers->first();
        }

        $messages = collect();
        if ($selectedUser) {
            Message::where('sender_id', $selectedUser->id)
                ->where('receiver_id', auth()->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            $messages = Message::with(['sender:id,name,role', 'receiver:id,name,role'])
                ->where(function ($query) use ($selectedUser) {
                    $query->where('sender_id', $selectedUser->id)
                        ->orWhere('receiver_id', $selectedUser->id);
                })
                ->where(function ($query) {
                    $query->whereHas('sender', function ($senderQuery) {
                        $senderQuery->where('role', 'admin');
                    })->orWhereHas('receiver', function ($receiverQuery) {
                        $receiverQuery->where('role', 'admin');
                    });
                })
                ->orderBy('created_at')
                ->get();
        }

        return view('admin.chat.index', compact('chatUsers', 'selectedUser', 'messages'));
    }

    /**
     * Store admin reply to selected user.
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Message::create([
            'sender_id' => (int) $request->user()->id,
            'receiver_id' => (int) $user->id,
            'message' => $validated['message'],
        ]);

        return redirect()->route('admin.chat.show', $user)->with('success', 'Balasan berhasil dikirim.');
    }
}
