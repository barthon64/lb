@extends('layouts.admin')

@section('content')

    <h3>Комментарии ({{$comments->total()}})</h3>
    <br>

    @if (Session::has('message'))
    <div class="alert alert-success" style="margin: 20px 0">{{ Session::get('message') }}</div>
    @endif

    @if($comments->total()==0)
        Комментарии не найдены
    @else

        @foreach($comments as $key=>$comment)
            <div style="line-height: 1.5em;color: #666666; font-size: 12px;">
                {{date('d.m.Y в H:i')}}  {{$comment->user->name}}
            </div>
            <div class="margin-top: 5px; color: grey">
                {{$comment->text}}
            </div>

            <div style="margin-top: 10px">
                <a href="{{route('admin.comments.edit', ['id'=>$comment->id])}}">Редактировать</a> | <a href="#" onClick="if(confirm('Удалить запись?')) {location.href='{{route('admin.comments.destroy', ['id'=>$comment->id])}}'} return false;">Удалить</a>
            </div>

            @if($key!=$comments->count()-1)
            <hr>
            @endif

        @endforeach

        {!! $comments->render() !!}

    @endif

@endsection