<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware(['api'])->group(static function (): void {

    Route::resource('categories', CategoryController::class)->only(['index']);
    
    Route::group(['prefix' => 'articles', 'as' => 'api.articles.'], static function (): void {
        
        Route::get('featured-latest-news', [ArticleController::class, 'getFeaturedLatestNews']);

        Route::get('{slug}', [ArticleController::class, 'showDetailArticle'])
            ->name('show-detail-article');
    });

});
