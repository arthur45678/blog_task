<?php

namespace App\Http\Controllers\Api;

use App\Contracts\LikeRepositoryInterface;
use App\Contracts\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\AddLikeRequest;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeRepository;
    protected $postRepository;

    public function __construct(LikeRepositoryInterface $likeRepository, PostRepositoryInterface $postRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->postRepository = $postRepository;
    }
    /**
     * @param $request
     * @param integer post id
     */
    public function addLike(AddLikeRequest $request)
    {
        $user_id = Auth::user()->id;
        $post_id = $request->post_id;
        $this->likeRepository->addLike($user_id,$post_id);
    }
    /**
     * @param $request
     * @param integer post id
     */
    public function unLike(AddLikeRequest $request)
    {
        $user_id = Auth::user()->id;
        $post_id = $request->post_id;
        $this->likeRepository->unLike($user_id,$post_id);
    }
}
