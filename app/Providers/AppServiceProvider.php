<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Contracts\BookServiceInterface;
use Modules\Catalog\Services\BookService;
use Modules\Circulation\Events\BookBorrowed;
use Modules\Circulation\Listeners\BookBorrowedListener;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
    BookServiceInterface::class,
    BookService::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
    BookBorrowed::class,
    BookBorrowedListener::class
    );
    }
}
