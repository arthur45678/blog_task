<?php

namespace App\Contracts;

interface BaseRepositoryInterface
{
    public function getAll();

    public function getByID($id);

    public function deleteItemById($id);

    public function getAllWithPagination();



}
