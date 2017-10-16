<?php

namespace App\Listeners;

use App\Events\CommentSaveEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentSaveListener
{

    public function __construct()
    {
        //
    }

    public function handle(CommentSaveEvent $event)
    {

        if($event->comment->wasRecentlyCreated) {
            $event->post->increment('comments_count', 1);
        }
    }
}