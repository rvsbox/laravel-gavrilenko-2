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

        // удаление записи из БД
        if ($request->isMethod('delete')) {
            $page->delete();

            return redirect('admin')->with('status', 'Страница удалена');
        }

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

            if ($validator->fails()) {
                return redirect()->route('pagesEdit', ['page' => $input['id']])->withErrors($validator);
            }

            // проверка загрузки файла на сервер
            // см видео 15-12:00
            if ($request->hasFile('images')) {

                // в переменную $file сохраняем объект класса UploadedFile для конкретного загруженного файла
                $file = $request->file('images');
                // копирование файла в определенную директорию на сервере
                $file->move(public_path().'/assets/img', $file->getClientOriginalName());
                // записываем в ячейку imgages имя файла
                $input['images'] = $file->getClientOriginalName();
            } else {
                // когда пользователь не загружает новое изображение, а использует старое
                // $input['old_images'] - скрытое поле с именем файла, которое было загружено ранее
                $input['images'] = $input['old_images'];
            }

            // удаление лишнего из массива $input, те из ячеки old_images
            unset($input['old_images']);

            // заново заполняем поля модели Page, но в качестве значений используем содержимое массива $input
            $page->fill($input);

            // пересохранение информации в БД
            if ($page->update()) {
                return redirect('admin')->with('status', 'Страница обновлена.');
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
