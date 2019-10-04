<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create-post','App\Policies\PostPolicy@create');
        Gate::define('update-post','App\Policies\PostPolicy@update');
        Gate::define('delete-post','App\Policies\PostPolicy@delete');
        Gate::define('restore-post','App\Policies\PostPolicy@restore');
        Gate::define('forceDelete-post','App\Policy\PostPolicy@forceDelete');
    }
}
