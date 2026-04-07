<?php

namespace App\Http\Controllers;

use App\Models\Contact;
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
        $messages = Contact::with('receiver')
            ->where('sender_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('user.contacts.index', compact('messages'));
    }
}
