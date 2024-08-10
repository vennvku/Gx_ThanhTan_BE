<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware(['api'])->group(static function (): void {

    Route::resource('categories', CategoryController::class)->only(['index']);
    Route::post('get-type-category', [CategoryController::class, 'getTypeCategory'])
            ->name('get-type-category');
    
    Route::get('get-chain-category/{idCategory}', [CategoryController::class, 'getChainCategory'])
        ->name('get-chain-category');
    
    Route::group(['prefix' => 'articles', 'as' => 'api.articles.'], static function (): void {
        
        Route::get('featured-latest-news', [ArticleController::class, 'getFeaturedLatestNews']);

        Route::get('{slug}', [ArticleController::class, 'showDetailArticle'])
            ->name('show-detail-article');
    });

    Route::get('show-detail-fixed-page/{idCategory}', [ArticleController::class, 'showDetailFixedPage'])
        ->name('show-detail-fixed-page');

});
