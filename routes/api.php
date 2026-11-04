<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\MenuController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\QuestionController;
use App\Http\Controllers\Api\V1\QuestionTopicController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\SlideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| REST API v1 for Flutter App & Public Clients
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    // CMS Posts & Categories
    Route::get('/posts', [PostController::class, 'index'])->name('api.v1.posts.index');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('api.v1.posts.show');
    Route::get('/categories', [CategoryController::class, 'index'])->name('api.v1.categories.index');

    // CMS Pages & Navigation
    Route::get('/pages/{slug}', [PageController::class, 'show'])->name('api.v1.pages.show');
    Route::get('/slides', [SlideController::class, 'index'])->name('api.v1.slides.index');
    Route::get('/menus/{location}', [MenuController::class, 'show'])->name('api.v1.menus.show');

    // Site Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('api.v1.settings.index');

    // Public Inquiries & FAQs
    Route::get('/faqs', [FaqController::class, 'index'])->name('api.v1.faqs.index');
    Route::get('/question-topics', [QuestionTopicController::class, 'index'])->name('api.v1.question-topics.index');
    Route::get('/questions', [QuestionController::class, 'index'])->name('api.v1.questions.index');
    Route::post('/questions', [QuestionController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('api.v1.questions.store');
});
