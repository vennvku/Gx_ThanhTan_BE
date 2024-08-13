<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware(['api'])->group(static function (): void {

    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::post('get-type-category', [CategoryController::class, 'getTypeCategory'])
            ->name('get-type-category');
    
    Route::get('get-chain-category/{slug}', [CategoryController::class, 'getChainCategory'])
        ->name('get-chain-category');
    
    // Route::group(['prefix' => 'articles', 'as' => 'api.articles.'], static function (): void {
        
    //     Route::get('{slug}', [ArticleController::class, 'showDetailArticle'])
    //         ->name('show-detail-article');
    // });

    Route::get('get-featured-latest-news', [ArticleController::class, 'getFeaturedLatestNews'])
    ->name('get-featured-latest-news');

    Route::get('show-detail-fixed-page/{slug}', [ArticleController::class, 'showDetailFixedPage'])
        ->name('show-detail-fixed-page');
    
    Route::get('get-top-featured-article', [ArticleController::class, 'getTopFeaturedArticle'])
        ->name('get-top-featured-article');

    Route::get('get-list-articles', [ArticleController::class, 'getListArticles'])
        ->name('get-list-articles');
    
    Route::get('get-latest-articles', [ArticleController::class, 'getLatestArticles'])
        ->name('get-latest-articles');

        

});
