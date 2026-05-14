<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(ContactStoreRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()->route('contacto')->with('status', 'Gracias por contactarnos. Pronto nos comunicaremos.');
    }
}
