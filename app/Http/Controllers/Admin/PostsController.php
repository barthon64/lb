<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;

use Illuminate\Http\Request;

class PostsController extends Controller {

	/**
	 * Display a listing of resources.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $data = array_map('trim', $request->all());

        $posts=Posts::orderBy('id', 'DESC');

        if(@$data['q']) {
            $posts->where('title', 'LIKE', '%'.$data['q'].'%');
            $posts->orWhere('text', 'LIKE', '%'.$data['q'].'%');
        }

        $posts=$posts->paginate(10);

        return view('admin.posts.index', ['posts'=>$posts]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Request $request)
	{
        $post=Posts::findOrFail($id);

        $categories=Categories::orderBy('name', 'ASC')->get();

        return view('admin.posts.edit', ['post'=>$post, 'categories'=>$categories]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{

        $validator=$this->validatePost($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data=$request->all();

        try {
            $post = Posts::findOrFail($id);
            $data['image']=$post->uploadImage($request, $post->image);
            $post->fill($data);
            $post->save();

            $post->categories()->sync(@(array)$data['category_id']);

        } catch(\Exception $e) {
            return back()->withErrors(['common'=>'Ошибка при сохранении данных'])->withInput();
        }

        return redirect()->route('admin.posts.index')->with(['message'=>'Данные успешно сохранены']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

        $post = Posts::findOrFail($id);
        $post->destroyImage($post->image);
        $post->destroy($id);

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
