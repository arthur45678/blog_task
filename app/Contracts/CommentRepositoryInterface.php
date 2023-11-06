<?php

namespace App\Contracts;

interface CommentRepositoryInterface
{
    public function addComment($post_id, $text);
}
