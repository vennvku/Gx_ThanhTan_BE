<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('byUsers', function (): void {
            /** @var Blueprint $this */
            $this->bigInteger('created_by')->nullable();
            $this->bigInteger('updated_by')->nullable();
            $this->bigInteger('deleted_by')->nullable();
        });
    }
}
 