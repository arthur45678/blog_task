<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commenRepository;
    protected $postRepository;

    public function __construct(PostRepository $postRepository,CommentRepository $commentRepository)
    {

        $this->postRepository = $postRepository;
        $this->commenRepository = $commentRepository;

    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCommentRequest $request)
    {

        $this->commenRepository->addComment($request->post_id, $request->body);
    }
    public function deleteComment(AddCommentRequest $request)
    {

        $this->commenRepository->deleteItemById($request->post_id, $request->body);
    }

}
