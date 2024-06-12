<?php

namespace App\Providers;

use App\Models\News;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use App\Policies\NewsPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Project::class => ProjectPolicy::class,
        News::class => NewsPolicy::class,
        User::class => UserPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // post
        Gate::define('view-any-post', [PostPolicy::class, 'viewAny']);
        Gate::define('view-post', [PostPolicy::class, 'view']);
        Gate::define('update-post', [PostPolicy::class, 'update']);
        Gate::define('delete-post', [PostPolicy::class, 'delete']);

        //news
        Gate::define('view-any-news', [NewsPolicy::class, 'viewAny']);
        Gate::define('view-news', [NewsPolicy::class, 'view']);
        Gate::define('create-news', [NewsPolicy::class, 'create']);
        Gate::define('update-news', [NewsPolicy::class, 'update']);
        Gate::define('delete-news', [NewsPolicy::class, 'delete']);

        // project
        Gate::define('view-any-project', [ProjectPolicy::class, 'viewAny']);
        Gate::define('view-project', [ProjectPolicy::class, 'view']);
        Gate::define('update-project', [ProjectPolicy::class, 'update']);
        Gate::define('delete-project', [ProjectPolicy::class, 'delete']);

        //user
        Gate::define('view-any-user', [UserPolicy::class, 'viewAny']);
        Gate::define('view-user', [UserPolicy::class, 'view']);
        Gate::define('update-user', [UserPolicy::class, 'update']);
    }
}
