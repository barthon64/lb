<?php namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class IndexController extends Controller {

    public function index()
    {
        return view('account.index');
    }



}
