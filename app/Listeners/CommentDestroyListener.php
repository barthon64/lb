<?php

namespace App\Listeners;

use App\Events\CommentDestroyEvent;
use App\Models\Posts;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentDestroyListener
{

    public function __construct()
    {
        //
    }

    public function handle(CommentDestroyEvent $event)
    {
        Posts::find( $event->comment->post_id)->decrement('comments_count', 1);
    }
}