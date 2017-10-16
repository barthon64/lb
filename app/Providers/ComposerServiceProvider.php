<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Регистрация привязок в контейнере.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('posts._categories', 'App\Http\ViewComposers\CategoriesComposer');

    }

    /**
     * Регистрация сервис-провайдера.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}