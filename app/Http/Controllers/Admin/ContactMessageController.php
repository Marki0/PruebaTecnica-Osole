<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        return view('admin.stub', ['title' => 'Mensajes de contacto']);
    }

    public function show(ContactMessage $contact_message): View
    {
        return view('admin.stub', ['title' => 'Mensaje #'.$contact_message->id]);
    }
}
