<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     *
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Blog\Author' => 'App\Policies\Blog\AuthorPolicy',
        'Ramnzys\FilamentEmailLog\Models\Email' => 'App\Policies\EmailPolicy'
    ];

    
    public function boot(): void
    {
       //
    }
}
