@extends('layouts.public')

@section('content')

    <div class="row">
        <div class="col-md-2">@include('posts._categories')</div>
        <div class="col-md-10">
            <ul class="media-list">
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
                        <div style="line-height: 1.5em;color: #666666; font-size: 12px;">
                            {{$post->user->name}} | {{date('d.m.Y в H:i')}} | Комментариев: {{$post->comments_count}}

                            @if($post->categories->count()>0)
                            | {{implode(', ', $post->categories->pluck('name')->toArray())}}
                            @endif

                        </div>
                        <br>
                        {{$post->text}}
                    </div>
                </li>
            </ul>

            <br>

            <!-- комментарии -->
            @include('comments._index')

        </div>
    </div>




@endsection

