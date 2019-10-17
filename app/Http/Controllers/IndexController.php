<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\People;
use App\Models\Portfolio;
use App\Models\Service;

class IndexController extends Controller
{
    //

    public function execute(Request $request)
    {
        $pages = Page::all();
        $portfolios = Portfolio::get(array('name', 'filter', 'images'));
        $services = Service::where('id', '<', 20)->get();
        $peoples = People::take(3)->get();

        dd($portfolios); // тестирование
//        dd($pages);
//        dd($services);
//        dd($peoples);

        $menu = array();
        foreach ($pages as $page) {

        }

        return view('site.index');
    }
}
