<a style="display: block; margin-bottom: 5px; @if(strpos(Request::route()->getName(), '.posts.')!==false) color: brown @endif " href="{{route('account.posts.index')}}">Мои записи</a>
<a style="display: block; margin-bottom: 5px; @if(strpos(Request::route()->getName(), '.comments.')!==false) color: brown @endif "  href="{{route('account.comments.index')}}">Мои комментарии</a>

