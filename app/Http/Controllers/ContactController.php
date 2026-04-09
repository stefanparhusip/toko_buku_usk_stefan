<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Store a message from user to admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $admin = User::where('role', 'admin')->orderBy('id')->first();

        if (! $admin) {
            return back()
                ->withInput()
                ->with('error', 'Admin belum tersedia. Coba lagi nanti.');
        }

        Contact::create([
            'sender_id' => (int) $request->user()->id,
            'receiver_id' => (int) $admin->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Pesan berhasil dikirim ke admin.');
    }

    /**
     * Show messages sent by authenticated user.
     */
    public function index(Request $request): View
    {
        if ($request->boolean('debug_messages')) {
            dd(Message::all());
        }

        $userId = (int) $request->user()->id;
        $adminIds = User::where('role', 'admin')->pluck('id');

        $messages = Message::with(['sender:id,name,role', 'receiver:id,name,role'])
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->where(function ($query) use ($userId, $adminIds) {
                $query->where(function ($userToAdminQuery) use ($userId, $adminIds) {
                    $userToAdminQuery->where('sender_id', $userId)
                        ->whereIn('receiver_id', $adminIds);
                })->orWhere(function ($adminToUserQuery) use ($userId, $adminIds) {
                    $adminToUserQuery->whereIn('sender_id', $adminIds)
                        ->where('receiver_id', $userId);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.contacts.index', compact('messages'));
    }
}
