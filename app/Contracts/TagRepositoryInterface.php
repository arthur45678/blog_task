<?php

namespace App\Contracts;

interface TagRepositoryInterface
{
    public function getPostWithSearchWord($searchParam =  false);
}
