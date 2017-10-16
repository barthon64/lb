<form id="comment_form" enctype="multipart/form-data" class="form-horizontal hidden" method="post" >
    <div class="form-group">
        <label for="text" class="col-sm-2 control-label">Текст</label>
        <div class="col-sm-7">
            <textarea class="form-control" id="text" name="text" rows="4" ></textarea>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <button type="button" class="btn btn-default" id="save_comment_btn">Сохранить</button>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="post_id" id="post_id" value="{{$post->id}}">
</form>