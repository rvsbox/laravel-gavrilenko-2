<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class PagesAddController extends Controller
{
    public function execute(Request $request)
    {
        if ($request->isMethod('post')) {

            // исключить параметр _token
            // получить нужную информацию из $request
            $input = $request->except('_token');

            // провалидировать данные из формы
            $validator = Validator::make($input, [

                // правила валидации. См видео 12-6:40
                'name' => 'required|max:255',
                'alias' => 'required|unique:pages|max:255',
                'text' => 'required',
            ]);

            // проверка
            if ($validator->fails()) {

                // withErrors() - сохранить информацию об ошибках в сессию
                // withInput() - сохранить информацию, добавленную в поля формы, в сессию
                return redirect()->route('pagesAdd')->withErrors($validator)->withInput();
            }

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
