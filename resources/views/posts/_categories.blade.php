@if($categories)
    <div >
        @foreach($categories as $key=>$item)
           <a style="display: block; margin-bottom: 5px; @if($item->id==@$category->id) color: brown @endif" href="{{route('public.posts.category', ['id'=>$item->id])}}">{{$item->name}}</a>
        @endforeach
    </div>
@endif

