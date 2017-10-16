@extends('layouts.public')

@section('content')

<h3>Комментарии: редактирование</h3>
    <br>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('admin.comments.update', ['id'=>@$comment->id]) }}" method="post">
        <div class="form-group">
            <label for="text" class="col-sm-2 control-label">Текст</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="text" name="text" rows="4" >{{ old('text', @$comment->text) }}</textarea>
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