<?php

namespace App\Listeners;

use App\Events\PostDestroyEvent;
use App\Models\Posts;


class PostDestroyListener
{

    public function __construct()
    {
        //
    }

    public function handle(PostDestroyEvent $event)
    {
        $event->post->categories()->detach();
        $event->post->comments()->delete();

        if($event->post->image!='') {
            $event->post->destroyImage($event->post->image);
        }

    }
}