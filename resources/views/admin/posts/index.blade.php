@extends('layouts.admin')

@section('content')

    <h3 style="margin-bottom: 20px">Записи (всего: {{$posts->total()}})</h3>

    @if (Session::has('message'))
        <div class="alert alert-success" style="margin: 20px 0">{{ Session::get('message') }}</div>
    @endif

    <nav class="navbar navbar-default" style="padding: 10px 5px 10px 5px">
        <form class="form-inline" action="{{route('admin.posts.index')}}" >
            <div class="form-group">
                <label>Текст</label>
                <input type="text" name="q" class="form-control" style="width: 400px" value="{{Request::input('q')}}" >
            </div>
            <button type="submit" class="btn btn-default">Искать</button>
        </form>
    </nav>

    @if($posts->total()==0)
        Записи не найдены
    @else
        <ul class="media-list">
            @foreach($posts as $key=>$post)
                <li class="media">
                    @if($post->image!='')
                    <div class="media-left">
                        <a href="{{route('posts.show', ['id'=>$post->id])}}">
                            <img class="media-object" src="{{url('/images/posts/150x100/'.$post->image)}}" >
                        </a>
                    </div>
                    @endif
                    <div class="media-body">
                        <h4 class="media-heading"><a href="{{route('posts.show', ['id'=>$post->id])}}">{{$post->title}}</a></h4>

                        <div style="line-height: 1.5em;color: #666666; font-size: 12px; margin-bottom: 10px">
                            {{$post->user->name}} | {{date('d.m.Y в H:i')}}

                            @if($post->categories->count()>0)
                            | {{implode(', ', $post->categories->pluck('name')->toArray())}}
                            @endif

                        </div>

                        {{str_limit($post->text, 500)}}

                        <div style="margin-top: 10px">
                            <a href="{{route('admin.posts.edit', ['id'=>$post->id])}}">Редактировать</a> | <a href="#" onClick="if(confirm('Удалить запись?')) {location.href='{{route('admin.posts.destroy', ['id'=>$post->id])}}'} return false;">Удалить</a>
                        </div>
                    </div>
                </li>

                @if($key!=$posts->count()-1)
                <hr>
                @endif

            @endforeach

            <br>
            {!! $posts->appends(Input::except('page'))->render() !!}

        </ul>
    @endif

@endsection