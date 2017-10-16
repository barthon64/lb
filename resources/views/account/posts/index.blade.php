@extends('layouts.account')

@section('content')

    <h3>Записи (всего: {{$posts->total()}})</h3>

    @if (Session::has('message'))
        <div class="alert alert-success" style="margin: 20px 0">{{ Session::get('message') }}</div>
    @endif

    <div style="margin: 20px 0">
        <a href="{{route('account.posts.create')}}">Добавить запись</a>
    </div>

    @if($posts->total()==0)
        Записи не найдены
    @else
        <ul class="media-list">
            @foreach($posts as $post)
                <li class="media">
                    @if($post->image!='')
                    <div class="media-left">
                        <a href="{{route('public.posts.show', ['id'=>$post->id])}}">
                            <img class="media-object" src="{{url('/images/posts/150x100/'.$post->image)}}" >
                        </a>
                    </div>
                    @endif
                    <div class="media-body">
                        <h4 class="media-heading"><a href="{{route('public.posts.show', ['id'=>$post->id])}}">{{$post->title}}</a></h4>
                        <div style="line-height: 1.5em;color: #666666; font-size: 12px; margin-bottom: 10px">
                            {{$post->user->name}} | {{date('d.m.Y в H:i')}} | Комментариев: {{$post->comments_count}}

                            @if($post->categories->count()>0)
                            | {{implode(', ', $post->categories->pluck('name')->toArray())}}
                            @endif

                        </div>

                        {{str_limit($post->text, 500)}}

                        <div style="margin-top: 10px">
                            <a href="{{route('account.posts.edit', ['id'=>$post->id])}}">Редактировать</a> | <a href="#" onClick="if(confirm('Удалить запись?')) {location.href='{{route('account.posts.destroy', ['id'=>$post->id])}}'} return false;">Удалить</a>
                        </div>
                    </div>
                </li>
            @endforeach

            {!! $posts->render() !!}

        </ul>
    @endif

@endsection