<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PagesController extends Controller
{
    public function execute()
    {

        if (view()->exists('admin.pages')) {

            // возвращает все записи из определенной таблицы
            $pages = Page::all();

            // если не указывать use App\Models\Page;
            //$pages = \App\Models\Page::all();

            $data = [
                'title' => 'Страницы',
                'pages' => $pages,
            ];

            return view('admin.pages', $data);
        }

        abort(404);
    }
}
