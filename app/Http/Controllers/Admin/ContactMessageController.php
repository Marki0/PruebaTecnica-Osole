<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::query()
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contact_message): View
    {
        if ($contact_message->read_at === null) {
            $contact_message->forceFill(['read_at' => now()])->save();
        }

        return view('admin.contact-messages.show', compact('contact_message'));
    }
}
