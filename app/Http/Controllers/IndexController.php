<?php namespace App\Http\Controllers;

use App\Models\Posts;

class IndexController extends Controller {

    public function index()
    {
        return view('index.index');
    }


}
