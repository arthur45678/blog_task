<?php

namespace App\Contracts;

interface LikeRepositoryInterface
{
    public function addLike($user_id,$post_id);
    public function unLike($user_id,$post_id);
}
