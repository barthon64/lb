<div id="comments">
    <div class="panel panel-default">
        <div class="panel-heading" style="border-bottom: none">
            Комментaрии ({{$comments->total()}})
            <div style="float: right"><a rel="nofollow" href="#" onClick="$('#comment_form').toggleClass('hidden'); return false;" >Добавить комментарий</a></div>
        </div>
        <div class="panel-body">
            @include('comments._form')

            @if($comments->total()==0)
                Комментарии не найдены
            @else

                @foreach($comments as $key=>$item)
                <div style="line-height: 1.5em;color: #666666; font-size: 12px;">
                    {{date('d.m.Y в H:i')}}  {{$item->user->name}}
                </div>

                <div class="margin-top: 5px; color: grey">
                    {{$item->text}}
                </div>

                @if($key!=$comments->count()-1)
                <hr>
                @endif

                @endforeach

                {!! $comments->render() !!}

            @endif
        </div>
    </div>

</div>






