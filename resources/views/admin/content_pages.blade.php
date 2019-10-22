<div style="margin:0px 50px 0px 50px;">

    @if($pages)

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Имя</th>
                <th>Псевдоним</th>
                <th>Текст</th>
                <th>Дата создания</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>

            @foreach($pages as $k => $page)

                <tr>
                    <td>{{ $page->id }}</td>
                    {{-- формирование ссылки на редактирование записи --}}
                    <td>{!! Html::link(route('pagesEdit',['page'=>$page->id]),$page->name,['alt'=>$page->name]) !!}</td>
                    <td>{{ $page->alias }}</td>
                    <td>{{ $page->text }}</td>
                    {{-- дата создания --}}
                    <td>{{ $page->created_at }}</td>

                    <td>
                        {{-- открыли форму --}}
                        {{-- ссылка на редактироване записи --}}
                        {!! Form::open(['url'=>route('pagesEdit',['page'=>$page->id]), 'class'=>'form-horizontal','method' => 'POST']) !!}
                        {{-- формируется строка: <input type="hidden" name="_method"  value="DELETE"> --}}
                        {{ method_field('DELETE') }}
                        {{-- отображение кнопки --}}
                        {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}

                        {{-- закрыли форму --}}
                        {!! Form::close() !!}
                    </td>
                </tr>

            @endforeach


            </tbody>
        </table>
    @endif

    {!! Html::link(route('pagesAdd'),'Новая страница') !!}

</div>