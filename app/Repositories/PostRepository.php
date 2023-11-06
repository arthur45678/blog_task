<?php

namespace App\Repositories;

use App\Contracts\PostRepositoryInterface;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostRepository extends BaseBaseRepository implements PostRepositoryInterface
{
    public function __construct()
    {

        $this->model = new Post();
    }



    public function getPostWithSearchParams($searchParams)
    {

        $tags = Tag::all();

        $query = Post::orderByDesc('id');

        if (!empty($value = $searchParams['id'])) {
            $query->where('id', $value);
        }

        if (!empty($value = $searchParams['name'])) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $searchParams['description'])) {
            $query->where('description', 'like', '%' . $value . '%');
        }

        if (!empty($value = $searchParams['tag'])) {
            $query->whereHas('tags', function ($query) use($value) {
                $query->where('name', $value);
            });
        }


        return $query->paginate(20);
    }

    /**
     * @param $request
     * @return string name
     * @return string description
     * @return array  tag_ids
     * @return file image
     */
    public function addItem($request){
        $post = new Post();
        $post->name = $request->input('name');
        $post->description = $request->input('description');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        $tagIds = $request->input('tag_ids');
        $post->tags()->attach($tagIds);
    }

    /**
     * @param $request
     * @return integer post id
     * @return string name
     * @return string description
     * @return array  tag_ids
     * @return file image
     */
    public function updateItem($request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->update($request->all());
        $post->save();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }
        $post->save();

        if(empty($request->tag_ids));
        $ids = $request->tag_ids;
        if(isset($ids)){
            $post->tags()->sync($ids);
            return $this;
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByID($id)
    {
        $item = Post::with('tags')->where('id',$id)->first();
        return $item;
    }



}
