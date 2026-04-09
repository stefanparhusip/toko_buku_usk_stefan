<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Display user chat room with admin.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        $admin = User::where('role', 'admin')->orderBy('id')->first();

        if (! $admin) {
            return redirect()->route('dashboard')->with('error', 'Admin belum tersedia untuk chat.');
        }

        $messages = Message::with(['sender:id,name,role', 'receiver:id,name,role'])
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
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

        return view('user.chat.index', compact('messages', 'admin'));
    }

    /**
     * Store user message to admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $admin = User::where('role', 'admin')->orderBy('id')->first();

        if (! $admin) {
            return back()->with('error', 'Admin belum tersedia untuk chat.');
        }

        Message::create([
            'sender_id' => (int) $request->user()->id,
            'receiver_id' => (int) $admin->id,
            'message' => $validated['message'],
        ]);

        return redirect()->route('chat.index')->with('success', 'Pesan berhasil dikirim.');
    }
}
