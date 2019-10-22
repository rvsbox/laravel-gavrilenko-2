<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Page;


class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request)
    {

        //$page = Page::find($id);

        if ($request->isMethod('post')) {

            // вытаскиваем данные, которые хранятся в полях $request
            // нас не интересует поле _token, те ключ
            $input = $request->except('_token');

            // валидация
            $validator = Validator::make($input, [

                // правила валидации. См видео 14-4:10
                'name' => 'required|max:255',
                // $input['id'] - исключение записи из поиска, те получим идентификатор который редактируем
                'alias' => 'required|max:255|unique:pages,alias,'.$input['id'],
                'text' => 'required',
            ]);

            if($validator->fails()) {
                return redirect()
                    ->route('pagesEdit',['page'=>$input['id']])
                    ->withErrors($validator);
            }
        }

        // получим значение из БД конкретной записи
        $old = $page->toArray();

        if (view()->exists('admin.pages_edit')) {

            $data = [
                'title' => 'Редактирование страницы - '.$old['name'],
                'data' => $old,
            ];

            return view('admin.pages_edit', $data);
        }
    }
}
