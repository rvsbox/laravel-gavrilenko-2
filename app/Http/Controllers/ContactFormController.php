<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function execute()
    {
        dd(request()->all());
    }
}
