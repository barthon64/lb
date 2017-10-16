@extends('layouts.account')

@section('content')

    <h3>@if(isset($post)) Редактирование @else Добавление @endif записи</h3>
    <br>
    @include('errors.list')

    <form enctype="multipart/form-data" class="form-horizontal" action="{{ isset($post) ? route('account.posts.update', ['id'=>@$post->id]) : route('account.posts.store') }}" method="post">
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">Название</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', @$post->title) }}" maxlength="255" />
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="form-group">
            <label for="text" class="col-sm-2 control-label">Текст</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="text" name="text" rows="4" >{{ old('text', @$post->text) }}</textarea>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="form-group">
            <label for="text" class="col-sm-2 control-label">Категория</label>
            <div class="col-sm-7">
                <select name="category_id[]" class="form-control" multiple style="width: 200px; height: 100px">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" @if(in_array($category->id, old('category_id', isset($post) ? $post->categories->pluck('id')->toArray() : array()))) selected @endif >{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="form-group">
            <label for="text" class="col-sm-2 control-label">Фото</label>
            <div class="col-sm-7">
                @if(@$post->image!='')
                    <img src="{{url('/images/posts/150x100/'.$post->image)}}"  />
                    <div style="margin: 5px 0 10px; display: block">
                        <input type="checkbox" name="destroy_image" value="1"  /> Удалить изображение
                    </div>
                @endif
                <input type="file" name="image" />
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-7">
                <button type="submit" class="btn btn-default">Сохранить</button>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

    </form>


@endsection