<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('posts',\App\Http\Controllers\Api\PostsController::class);
Route::apiResource('tags',\App\Http\Controllers\Api\TagController::class);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('comments', [\App\Http\Controllers\Api\CommentController::class,'store']);
    Route::post('comments/delete', [\App\Http\Controllers\Api\CommentController::class,'deleteComment']);
    Route::post('add-like', [\App\Http\Controllers\Api\LikeController::class, 'addLike']);
    Route::post('un-like', [\App\Http\Controllers\Api\LikeController::class, 'unLike']);
});

require __DIR__.'/auth_api.php';
