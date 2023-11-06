<?php

namespace App\Repositories;

use App\Contracts\TagRepositoryInterface;
use App\Models\Tag;

class TagRepository extends BaseBaseRepository implements TagRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Tag();
    }

    public function addItem($data){
        return Tag::create($data);
    }

    public function getPostWithSearchWord($keyword = false)
    {
        $perPage = 25;

        if (!empty($keyword)) {
            $posts = Tag::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $posts = Tag::latest()->paginate($perPage);
        }
        return $posts;
    }


}
