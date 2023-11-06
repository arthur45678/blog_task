<?php

namespace App\Repositories;

use App\Contracts\CommentRepositoryInterface;
use App\Contracts\TagRepositoryInterface;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class CommentRepository extends BaseBaseRepository implements CommentRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Comment();
    }

    public function addComment($post_id, $text)
    {
        $post = Post::findOrFail($post_id);
        $post->comments->body = $text;
        $post->comments->user_id = 1;

        $this->model::create([
            'user_id' => Auth::user()->id,
            'post_id' => $post_id,
            'body' => $text,
        ]);
        return ;
    }

    public function deleteItemById($id)
    {
        return $this->model::where(['id' => $id,'user_id' => Auth::user()->id])->delete();
    }



}
