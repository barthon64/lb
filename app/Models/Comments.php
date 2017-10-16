<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model {

    protected $table = 'comments';

    protected $fillable = ['text'];

    public function post()
    {
        return $this->belongsTo('App\Models\Posts');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }



}
