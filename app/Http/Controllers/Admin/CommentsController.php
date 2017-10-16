<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;
use App\Events\CommentDestroyEvent;

use Illuminate\Http\Request;

class CommentsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $comments=Comments::orderBy('id', 'DESC')->paginate(1);

        return view('admin.comments.index', ['comments'=>$comments]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $comment=Comments::findOrFail($id);

        return view('account.comments.edit', ['comment'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $comment = Comments::findOrFail($id);

        $data=$request->all();
        try {

            $validator=$this->validateComment($request);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $comment->fill($data);
            $comment->save();

        } catch(\Exception $e) {
            return back()->withErrors(['common'=>'Ошибка при сохранении данных'])->withInput();
        }

        return redirect()->route('admin.comments.index')->with(['message'=>'Данные успешно сохранены']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        $comment = Comments::findOrFail($id);
        $comment->delete();

        \Event::fire(new CommentDestroyEvent($comment));

        return back();
    }

    function validateComment($request) {

        $validator = \Validator::make($request->all(), [
            'text' => 'required',
            'image' => 'mimes:jpeg|max:200'

        ],[
            'text.required' => 'Введите текст',
        ]);

        return $validator;

    }

}
