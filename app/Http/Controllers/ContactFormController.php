<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

// тестировать на специальном сайте mailtrap.io
class ContactFormController extends Controller
{
    public function execute(Request $request)
    {
        // сообщения о правилах заполнения формы
        $messages = [
            'required' => "test 1 :attribute",
            'email' => "test 2 :attribute",
        ];

        // валидация данных. Используется если в параметрах функции execute не указывать объект
        //$data = request()->validate([
        //    'name' => 'required|max:255',
        //    'email' => 'required|email',
        //    'text' => 'required',
        //]);

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'text' => 'required',
        ], $messages);

        //dump($request);
        //dd($request);
        //dd(request()); // используется если в параметрах функции execute не указывать объект

        $name = $request->input('name');
        $email = $request->input('email');
        $text = $request->input('text');
        //$subject = subject('Question');

        $data = ['name' => $name, 'email' => $email, 'text' => $text];
        //$data = $request->all(); // альтернатива

        //dd($data);

        // mail кому отправляется
        $mail_admin = env('MAIL_ADMIN');

        Mail::to($mail_admin)->send(new ContactFormMail($data));

        // вернуться на главную страницу
        return  redirect()->route('home');

        // откроется читая страница с сообщением
        //die('Mail sent!');
    }
}
