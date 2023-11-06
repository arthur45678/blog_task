<?php

namespace App\Repositories;

use App\Contracts\CommentRepositoryInterface;
use App\Contracts\LikeRepositoryInterface;
use App\Contracts\TagRepositoryInterface;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class LikeRepository extends BaseBaseRepository implements LikeRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Like();
    }

    public function addLike($user_id, $post_id)
    {
        $post = Post::where('id', $post_id)->first();
        if($post){
           $post->likes()->sync([
               'post_id' => $post_id,
               'user_id' => $user_id
           ]);
        }
    }

    public function unLike($user_id, $post_id)
    {
        $post = Post::where('id', $post_id)->first();
        if($post){
            $post->likes()->detach([
                'post_id' => $post_id,
                'user_id' => $user_id
            ]);
        }
    }


}
