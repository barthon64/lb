<?php namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Posts;
use Illuminate\Http\Request;
use App\Events\CommentSaveEvent;

class CommentsController extends Controller {


    function load($post_id, Request $request) {

        $post=Posts::findOrFail($post_id);

        $comments=$post->comments()->orderBy('id', 'DESC')->paginate(1);
        $response['comments']=\View::make('comments._index', ['comments'=>$comments, 'post'=>$post])->render();

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $post=Posts::findOrFail(@$request->post_id);

        $validator=$this->validateComment($request);

        $response=[];
        if($validator->fails()) {
            $response['errors']=$validator->getMessageBag()->all();
        } else {

            $data=$request->all();
            $comment = new Comments($data);
            $comment->user()->associate(\Auth::user());
            $post->comments()->save($comment);

            \Event::fire(new CommentSaveEvent($comment, $post));

            $comments=$post->comments()->orderBy('id', 'DESC')->paginate(1);
            $response['comments']=\View::make('comments._index', ['comments'=>$comments, 'post'=>$post])->render();

        }

        return response()->json($response);


    }

    function validateComment($request) {

        $validator = \Validator::make($request->all(), [
            'text' => 'required',
            'post_id' => 'min:1'
        ],[
            'text.required' => 'Введите текст'
        ]);

        return $validator;

    }

}
