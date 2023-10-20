<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Profile;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    view()->composer('layouts.app', function ($view) {
      $profiles = Profile::find(1);
      $view->with(compact('profiles'));
    });
  }
}
