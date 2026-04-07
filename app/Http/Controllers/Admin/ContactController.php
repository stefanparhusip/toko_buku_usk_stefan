<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display list of user messages.
     */
    public function index(): View
    {
        $contacts = Contact::with('sender')
            ->latest()
            ->paginate(12);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show detail of one message.
     */
    public function show(Contact $contact): View
    {
        $contact->load(['sender', 'receiver']);

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Save admin reply.
     */
    public function updateReply(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'reply' => ['required', 'string'],
        ]);

        $contact->update([
            'reply' => $validated['reply'],
        ]);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Balasan berhasil disimpan.');
    }
}
