<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Blog\Author' => 'App\Policies\Blog\AuthorPolicy',
        'Ramnzys\FilamentEmailLog\Models\Email' => 'App\Policies\EmailPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
       //
    }
}
