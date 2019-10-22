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

            // проверить, содержится ли файл в объекте $request. Что если пользователь его не загрузил
            // hasFile() возваращает истину если файл содержиться в объекте $request
            if($request->hasFile('images')){

                // перед сохранением информации в БД, необходимо сохранить изображение в определенный каталог,
                // которое отправляется на сервер
                // в переменной $file будет располагаться класс UploadFile, те получим экземпляр объекта UploadFile
                $file = $request->file('images');

                // очистка от лишней информации в ячейке images
                $input['images'] = $file->getClientOriginalName();
            }

            // сохранение файла в определенный каталог проекта
            // move() - сохраняет файл в указанную директорию
            // public_path() - возвращает путь к публичной директории фреймворка Laravel, те каталог public
            // во втором аргументе public_path() указываем имя сохраняемого файла
            $file->move(public_path().'/assets/img',$input['images']);

        }

        dd($input);

        if (view()->exists('admin.pages_add')) {

            $data = [
                'title' => 'Новая страница',
            ];

            return view('admin.pages_add', $data);
        }

        abort(404);
        
    }
}
