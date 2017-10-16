<?php

namespace App\Http\ViewComposers;

use App\Models\Categories;
use Illuminate\Contracts\View\View;

class CategoriesComposer
{

    /**
     * Привязка данных к представлению.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $categories=Categories::orderBy('name', 'ASC')->get();

        $view->with('categories', $categories);
    }
}