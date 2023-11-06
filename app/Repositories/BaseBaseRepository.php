<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use App\Models\Post;

class BaseBaseRepository implements BaseRepositoryInterface
{
    protected $model;

    /**
     * @return mixed
     */
    public function getAllWithPagination()
    {
        return $this->model::orderBy(
            'id', 'Desc'
        )->paginate(15);

    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->model::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getByID($id)
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteItemById($id)
    {
        return $this->model::findOrFail($id)->delete();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addItem($data){
        return $this->model::create($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateItem($data, $id)
    {
        $item = $this->model::where('id',$id)->first();
        if($item){
            $item->update($data);
        }
        return $item;
    }



}
