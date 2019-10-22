<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            dd($input);
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
