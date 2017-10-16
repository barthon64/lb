<?php

use Illuminate\Http\Request;
use  App\Task;
use App\Http\Middleware\VerifyCsrfToken;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');

//Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);

Route::get('/posts/', ['as' => 'public.posts.index', 'uses' => 'PostsController@index']);
Route::get('/posts/category/{categoryId}', ['as' => 'public.posts.category', 'uses' => 'PostsController@index']);
Route::get('/posts/show/{id}', ['as' => 'public.posts.show', 'uses' => 'PostsController@show']);

Route::post('/comments/store', ['middleware' => 'auth', 'as' => 'comments.store', 'uses' => 'CommentsController@store']);
Route::get('/comments/load/{postId}', ['as' => 'comments.load', 'uses' => 'CommentsController@load']);

Route::get('/account', ['as' => 'account.index', 'middleware' => ['auth'], 'uses' => 'Account\IndexController@index']);

Route::group(['as' => 'account.posts.', 'prefix' => '/account/posts/', 'middleware' => ['auth']], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Account\PostsController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'Account\PostsController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'Account\PostsController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Account\PostsController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'Account\PostsController@update']);
    Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'Account\PostsController@destroy']);
});

Route::group(['as' => 'account.comments.', 'prefix' => '/account/comments/', 'middleware' => ['auth']], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Account\CommentsController@index']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Account\CommentsController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'Account\CommentsController@update']);
    Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'Account\CommentsController@destroy']);
});

Route::group(['as' => 'admin.', 'prefix' => '/admin/', 'middleware' => ['auth', 'admin']], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Admin\IndexController@index']);
    Route::get('posts', ['as' => 'posts.index', 'uses' => 'Admin\PostsController@index']);
    Route::get('posts/edit/{id}', ['as' => 'posts.edit', 'uses' => 'Admin\PostsController@edit']);
    Route::post('posts/update/{id}', ['as' => 'posts.update', 'uses' => 'Admin\PostsController@update']);
    Route::get('posts/destroy/{id}', ['as' => 'posts.destroy', 'uses' => 'Admin\PostsController@destroy']);

    Route::get('comments', ['as' => 'comments.index', 'uses' => 'Admin\CommentsController@index']);
    Route::get('comments/edit/{id}', ['as' => 'comments.edit', 'uses' => 'Admin\CommentsController@edit']);
    Route::post('comments/update/{id}', ['as' => 'comments.update', 'uses' => 'Admin\CommentsController@update']);
    Route::get('comments/destroy/{id}', ['as' => 'comments.destroy', 'uses' => 'Admin\CommentsController@destroy']);

});





