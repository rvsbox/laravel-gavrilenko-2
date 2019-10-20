<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function execute($alias)
    {
        // пример если alias не найден
        //$alias = false;

        if (!$alias) {
            abort(404);
        }

        // существует ли конкретный шаблон
        if (view()->exists('site.page')) {

            // где `alias` = $alias.
            // $alias передоваемый параметр функции execute()
            // `alias` - поле
            // strip_tags() — удаляет теги HTML и PHP из строки с целью безопасности
            // через модель Page получаем доступ к таблице pages в БД
            // модели Page, People, Portfolio... необходимы для выборки информации из БД
            // определяем в каком из двух первых разделов после меню нажата кнопка, те получаем псевдоним alias
            // метод first() возвращает первый элемент в коллекции, который подходит под заданное условие
            // получаем одно значение
            $page = Page::where('alias', strip_tags($alias))->first();

            // получаем массив. Не подходит
            //$page = Page::where('alias', strip_tags($alias))->get();

            // формируем переменную с необходимыми параметрами для передачи в шаблон
            $data = [
                // будет заголовком страницы
                'title' => $page->name,
                // передаем модель Page
                'page' => $page,
            ];

            return view('site.page', $data);

        } else {

            abort(404);

        }

        echo 'PageController';
    }
}
