<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactFormController extends Controller
{
    public function execute()
    {
        // валидация данных
        $data = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'text' => 'required',
        ]);

        Mail::to('test@test.com')->send(new ContactFormMail($data));

        return  redirect()-route('home');
    }
}
