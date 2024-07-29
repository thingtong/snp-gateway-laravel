<?php

namespace App\Providers;

use App\Repositories\ExampleNoteRepository;
use App\Repositories\Interfaces\ExampleNote;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ExampleNote::class,
            ExampleNoteRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
