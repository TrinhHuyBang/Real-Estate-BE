<?php

namespace App\Providers;

use App\Interfaces\BookmarkRepoInterface;
use App\Interfaces\PostImageRepoInterface;
use App\Interfaces\PostRepoInterface;
use App\Interfaces\ProjectRepoInterface;
use App\Interfaces\UserRepoInterface;
use App\Repos\BookmarkRepo;
use App\Repos\PostImageRepo;
use App\Repos\PostRepo;
use App\Repos\ProjectRepo;
use App\Repos\UserRepo;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostRepoInterface::class, PostRepo::class);
        $this->app->bind(PostImageRepoInterface::class, PostImageRepo::class);
        $this->app->bind(BookmarkRepoInterface::class, BookmarkRepo::class);
        $this->app->bind(UserRepoInterface::class, UserRepo::class);
        $this->app->bind(ProjectRepoInterface::class, ProjectRepo::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
