<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

// группа маршрутов для пользовательской части
Route::group(['middleware' => 'web'], function () {

    // главная страница
    Route::match(['get', 'post'], '/', [
        'uses' => 'IndexController@execute',
        'as' => 'home',
    ]);

    Route::post('/', ['uses' => 'ContactFormController@execute', 'as' => 'form']);

    // параметр {alias} будет передаваться в качестве первого аргумента метода execute в PageController
    Route::get('/page/{alias}', ['uses' => 'PageController@execute', 'as' => 'page']);

    // аутентификация пользователя
    Route::auth();
});

// группа маршрутов для закрытого раздела
// /admin/page
// /admin/service
// /admin/portfolio
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    // главная страница панели администратора
    // laravel-gavrilenko-2.loc/admin
    Route::get('/', function () {

        if (view()->exists('admin.index')) {
            $data = ['title' => 'Панель администратора'];

            return view('admin.index', $data);
        }

    });

    // /admin/pages
    Route::group(['prefix' => 'pages'], function () {

        // /admin/pages
        Route::get('/', ['uses' => 'PagesController@execute', 'as' => 'pages']);

        // /admin/pages/add
        Route::match(['get', 'post'], '/add', ['uses' => 'PagesAddController@execute', 'as' => 'pagesAdd']);

        // {page} - указываем конкретную страницу (идентификатор) для редактирования
        // /admin/edit/2
        Route::match(['get', 'post', 'delete'], '/edit/{page}', [
            'uses' => 'PagesEditController@execute',
            'as' => 'pagesEdit',
        ]);
    });

    // /admin/portfolio
    Route::group(['prefix' => 'portfolios'], function () {

        Route::get('/', ['uses' => 'PortfolioController@execute', 'as' => 'portfolio']);

        Route::match(['get', 'post'], '/add', ['uses' => 'PortfolioAddController@execute', 'as' => 'portfolioAdd']);

        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', [
            'uses' => 'PortfolioEditController@execute',
            'as' => 'portfolioEdit',
        ]);
    });

    // /admin/services
    Route::group(['prefix' => 'services'], function () {

        Route::get('/', ['uses' => 'ServiceController@execute', 'as' => 'services']);

        Route::match(['get', 'post'], '/add', ['uses' => 'ServiceAddController@execute', 'as' => 'serviceAdd']);

        Route::match(['get', 'post', 'delete'], '/edit/{service}', [
            'uses' => 'ServiceEditController@execute',
            'as' => 'serviceEdit',
        ]);
    });
});

// generation (php artisan make:auth)
Auth::routes();

// generation (php artisan make:auth)
Route::get('/home', 'HomeController@index')->name('home');
