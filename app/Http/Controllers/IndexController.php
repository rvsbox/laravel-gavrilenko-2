<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\People;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function execute(Request $request)
    {
        // какой тип запроса использует пользователь
        if ($request->isMethod('post')) {
            // пользовательские правила для каждого из правил ниже
            $messages = [
                'required' => "Поле :attribute обязательно к заполнению",
                'email' => "Поле :attribute должно соответствовать email адресу"
            ];

            // валидация данных
            $this->validate($request,[
                // список правил валидации для каждого поля request
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'

            ], $messages);

            // для тестирования необходим отправить пустую форму, то laravel сделает редирект,
            // a при заполнении сработает метод dump()
            dump($request);
        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
        $services = Service::where('id', '<', 20)->get();
        $peoples = People::take(3)->get();

        // отображение фильтров в разделе Portfolio
        // для выборки уникальных значений используется метод distinct(), тк элементы дублируются
        $tags = DB::table('portfolios')->distinct()->pluck('filter');

        $menu = [];

        foreach ($pages as $page) {
            $item = ['title' => $page->name, 'alias' => $page->alias];
            array_push($menu, $item);
        }

        $item = ['title' => 'Services', 'alias' => 'service']; // alias - псевдоним. См id в верстке
        array_push($menu, $item);

        $item = ['title' => 'Portfolio', 'alias' => 'Portfolio'];
        array_push($menu, $item);

        $item = ['title' => 'Team', 'alias' => 'team'];
        array_push($menu, $item);

        $item = ['title' => 'Contact', 'alias' => 'contact'];
        array_push($menu, $item);

        // передача переменных виду
        return view('site.index', [
            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'peoples' => $peoples,
            'tags' => $tags,
        ]);
    }
}
