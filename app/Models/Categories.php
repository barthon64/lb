<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {

    protected $table = 'categories';

    public function posts()
    {
        return $this->belongsToMany('App\Models\Posts', 'posts_to_categories', 'category_id', 'post_id');
    }
}
