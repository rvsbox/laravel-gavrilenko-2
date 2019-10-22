<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request)
    {

        //$page = Page::find($id);

        // получим значение из БД конкретной записи
        $old = $page->toArray();

        dd($old);

    }
}
