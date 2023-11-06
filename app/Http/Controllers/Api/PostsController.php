<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PostRepositoryInterface;
use App\Contracts\TagRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostsController extends Controller
{
    public $postRepository;
    public $tagRepository;

    public function __construct(PostRepositoryInterface $postRepository,TagRepositoryInterface $tagRepository)
    {

        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;

    }


    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get a list of posts",
     *     description="Get a paginated list of posts with optional filtering by ID, name, description, and tags.",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Filter by post ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by post name (supports partial matching)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Filter by post description (supports partial matching)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         description="Filter by tag(s)",
     *         required=false,
     *         @OA\Schema(type="array", @OA\Items(type="integer"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of posts",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */

    /**
     * @param $request
     * @param  integer id
     * @param  string name
     * @param string description
     * @param array  tag[] // ids
     */
    public function index(Request $request)
    {
        $tags = \App\Models\Tag::all();

        $query = Post::orderByDesc('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('posts.id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('description'))) {
            $query->where('description', 'like', '%' . $value . '%');
        }

        foreach ($request->get('tag') as $tag_id) {
            if (!empty($value = $tag_id)) {
                $query->whereHas('tags', function ($query) use($value) {
                    $query->where('tags.id', $value);
                });
            }
        }

        return $query->paginate(20);
    }

    /**
     * @param $request
     * @param string name
     * @param string description
     * @param array  tag_ids
     * @param file image
     */
    public function store(CreatePostRequest $request)
    {
        $validatedData = $request->validated();

        $post = $this->postRepository->addItem($request);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @param \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->postRepository->getByID($id);

        return $item;
    }

    /**
     * @param $request
     * @param integer post id
     * @param string name
     * @param string description
     * @param array  tag_ids
     * @param file image
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $validatedData = $request->validated();

        $this->postRepository->updateItem($request,$id);

        return response()->json(['message' => 'Post updated successfully'], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @param \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->postRepository->deleteItemById($id);

        return response()->json(null, 204);
    }
}
