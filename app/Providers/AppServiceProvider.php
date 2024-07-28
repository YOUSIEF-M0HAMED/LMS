<?php

namespace App\Providers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;

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
      Relation::morphMap([
        'student' => \App\Models\Student::class,
        'teacher' => \App\Models\Teacher::class,
        'admin' => \App\Models\Admin::class,
    ]);
  }
}