<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model {

    protected $table = 'posts';

    protected $fillable = ['title', 'text', 'user_id', 'image', 'image1'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Categories', 'posts_to_categories', 'post_id', 'category_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comments', 'post_id');
    }

    public function scopeWithCategories($query)  {
        $query->join('posts_to_categories','posts.id', '=', 'posts_to_categories.post_id');
        $query->groupBy('id');
    }

    function destroyImage($image) {

        if($image=='') return;

        $path=public_path().'/images/posts/';
        @unlink($path.$image);

        foreach(\Config::get('app.imageThumbs') as $thumb) {
            @unlink($path.$thumb['aliace'].'/'.$image);
        }

    }

    function uploadImage($request, $oldFile='') {

        $file=$request->file('image');

        $filename=$oldFile;
        if($file and $file->getError()==UPLOAD_ERR_OK) {

            $uploaded=1;
            $filename=md5(uniqid('', true)).'.'.$file->getClientOriginalExtension();

            $imagePath=public_path().'/images/posts/';
            @mkdir($imagePath, 0777, true);
            $file->move($imagePath, $filename);

            foreach(\Config::get('app.imageThumbs') as $thumb) {
                $imageThumbPath=$imagePath.$thumb['aliace'];
                $img = \Image::make($imagePath.$filename);
                $img->resize($thumb['width'], $thumb['height']);
                @mkdir($imageThumbPath, 0777, true);
                $img->save($imageThumbPath.'/'.$filename);
            }
        }

        if((isset($uploaded) or $request->destroy_image==1) and $oldFile!='') {
            $this->destroyImage($oldFile);
        }

        if(!isset($uploaded) and $request->destroy_image==1) {
            $filename='';
        }

        return $filename;

    }

}
