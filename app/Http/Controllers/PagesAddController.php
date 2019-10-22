<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesAddController extends Controller
{
    public function execute(Request $request)
    {
        if ($request->isMethod('post')) {

            // исключить параметр _token
            // получить нужную информацию из $request
            $input = $request->except('_token');
            dd($input);
        }

        if (view()->exists('admin.pages_add')) {

            $data = [
                'title' => 'Новая страница',
            ];

            return view('admin.pages_add', $data);
        }

        abort(404);
    }
}
