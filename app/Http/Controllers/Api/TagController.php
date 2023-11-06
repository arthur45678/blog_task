<?php

namespace App\Http\Controllers\Api;

use App\Contracts\TagRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Repositories\TagRepository;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {

        $this->tagRepository = $tagRepository;

    }

    public function index(Request $request)
    {
        $searchWord = $request->get('search');
        $posts = $this->tagRepository->getPostWithSearchWord($searchWord);

        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'string'
		]);
        $tag = $this->tagRepository->addItem($request->all());

        return response()->json($tag, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tag = $this->tagRepository->getByID($id);

        return $tag;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'string'
		]);
        $tag = $this->tagRepository->updateItem($request->all(),$id);

        if(!$tag){
            return response()->json(['message' => 'Tag not found'], 404);
        }
        return response()->json($tag, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->tagRepository->deleteItemById($id);

        return response()->json(null, 204);
    }
}
