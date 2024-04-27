<?php

namespace App\Providers;

use App\Interfaces\AdviceRequestRepoInterface;
use App\Interfaces\BookmarkRepoInterface;
use App\Interfaces\BrokerAdviceRequestRepoInteface;
use App\Interfaces\BrokerageAreaRepoInterface;
use App\Interfaces\BrokerRepoInterface;
use App\Interfaces\BrokerReviewRepoInterface;
use App\Interfaces\EnterpriseRepoInterface;
use App\Interfaces\NotificationRepoInterface;
use App\Interfaces\PasswordResetRepoInterface;
use App\Interfaces\PostImageRepoInterface;
use App\Interfaces\PostRepoInterface;
use App\Interfaces\PostViewHistoryRepoInterface;
use App\Interfaces\ProjectRepoInterface;
use App\Interfaces\ReviewRepoInterface;
use App\Interfaces\SubFieldRepoInterface;
use App\Interfaces\UserRepoInterface;
use App\Interfaces\VerifyEmailTokenRepoInterface;
use App\Repos\AdviceRequestRepo;
use App\Repos\BookmarkRepo;
use App\Repos\BrokerAdviceRequestRepo;
use App\Repos\BrokerageAreaRepo;
use App\Repos\BrokerRepo;
use App\Repos\BrokerReviewRepo;
use App\Repos\EnterpriseRepo;
use App\Repos\NotificationRepo;
use App\Repos\PasswordResetRepo;
use App\Repos\PostImageRepo;
use App\Repos\PostRepo;
use App\Repos\PostViewHistoryRepo;
use App\Repos\ProjectRepo;
use App\Repos\ReviewRepo;
use App\Repos\SubFieldRepo;
use App\Repos\UserRepo;
use App\Repos\VerifyEmailTokenRepo;
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
        $this->app->bind(PasswordResetRepoInterface::class, PasswordResetRepo::class);
        $this->app->bind(PostViewHistoryRepoInterface::class, PostViewHistoryRepo::class);
        $this->app->bind(VerifyEmailTokenRepoInterface::class, VerifyEmailTokenRepo::class);
        $this->app->bind(ReviewRepoInterface::class, ReviewRepo::class);
        $this->app->bind(EnterpriseRepoInterface::class, EnterpriseRepo::class);
        $this->app->bind(SubFieldRepoInterface::class, SubFieldRepo::class);
        $this->app->bind(NotificationRepoInterface::class, NotificationRepo::class);
        $this->app->bind(BrokerRepoInterface::class, BrokerRepo::class);
        $this->app->bind(BrokerageAreaRepoInterface::class, BrokerageAreaRepo::class);
        $this->app->bind(BrokerReviewRepoInterface::class, BrokerReviewRepo::class);
        $this->app->bind(AdviceRequestRepoInterface::class, AdviceRequestRepo::class);
        $this->app->bind(BrokerAdviceRequestRepoInteface::class, BrokerAdviceRequestRepo::class);
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
