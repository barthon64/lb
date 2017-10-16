<?php namespace App\Http\Controllers\Account;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use App\Events\PostDestroyEvent;
use App\Models\Categories;

use Illuminate\Http\Request;

class PostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $posts=Auth::user()->posts()->orderBy('id', 'DESC')->paginate(1);

        return view('account.posts.index', ['posts'=>$posts]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $categories=Categories::orderBy('name', 'ASC')->get();

        return view('account.posts.edit', ['categories'=>$categories]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator=$this->validatePost($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data=$request->all();

        try {
            $post = new Posts();
            $data['image']=$post->uploadImage($request);
            $post->fill($data);
            $post->user()->associate(Auth::user())->save();
            //Auth::user()->posts()->save($post);

            $post->categories()->sync(@(array)$data['category_id']);

        } catch(\Exception $e) {
            return back()->withErrors(['common'=>'Ошибка при сохранении данных'])->withInput();
        }

        return redirect()->route('account.posts.index')->with(['message'=>'Данные успешно сохранены']);

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $post=Auth::user()->posts()->findOrFail($id);

        $categories=Categories::orderBy('name', 'ASC')->get();

        return view('account.posts.edit', ['post'=>$post, 'categories'=>$categories]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
        $post = Auth::user()->posts()->findOrFail($id);

        $data=$request->all();

        try {

            $validator=$this->validatePost($request);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $data['image']=$post->uploadImage($request, $post->image);
            $post->fill($data);
            $post->save();

            $post->categories()->sync(@(array)$data['category_id']);

        } catch(\Exception $e) {
            return back()->withErrors(['common'=>'Ошибка при сохранении данных'.$e->getMessage()])->withInput();
        }

        return redirect()->route('account.posts.index')->with(['message'=>'Данные успешно сохранены']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{  
        $post = Auth::user()->posts()->findOrFail($id);
        $post->delete();

        \Event::fire(new PostDestroyEvent($post));

        return back();
	}

    function validatePost($request) {

        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'text' => 'required',
            'image' => 'mimes:jpeg|max:200'

        ],[
            'title.required' => 'Введите название',
            'text.required' => 'Введите текст',
            'image.mimes' => 'Изображение должно быть в формате jpeg',
            'image.max' => 'Максимальный размер изображения 200Кб',
        ]);

        return $validator;

    }

}
