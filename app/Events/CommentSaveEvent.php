<?php

namespace App\Events;

use App\Models\Comments;
use App\Events\Event;


class CommentSaveEvent extends Event
{
    public $comment;

    public function __construct($comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }
}