<?php

namespace App\Events;

use App\Models\Comments;
use App\Events\Event;


class CommentDestroyEvent extends Event
{
    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }
}