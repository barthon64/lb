<?php namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Posts;
use App\Events\CommentSaveEvent;

class PostsController extends Controller {

    public function index($categoryId=0)
    {
        $posts=new Posts;

        if($categoryId>0) {
            $category=Categories::findOrFail($categoryId);
            $posts=$posts->withCategories();
            $posts->where('category_id', '=', $categoryId);
        }

        $posts=$posts->paginate(10);

        return view('posts.index', compact(['posts', 'category']));
    }

    public function show($id)
    {
        $post=Posts::findOrFail($id);

        $comments=$post->comments()->orderBy('id', 'DESC')->paginate(1);

        return view('posts.show', ['post'=>$post, 'comments'=>$comments]);
    }

}
