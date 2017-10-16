<?php

namespace App\Events;

use App\Models\Posts;
use App\Events\Event;


class PostDestroyEvent extends Event
{
    public $post;

    public function __construct($post)
    {
        $this->post = $post;
    }
}