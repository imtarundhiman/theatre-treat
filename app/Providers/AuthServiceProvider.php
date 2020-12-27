<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Movie;
use App\Models\Theatre;
use App\Models\TimeSlot;
use App\Models\Show;
use App\Models;
use App\Policies;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Movie::class => Policies\MoviesPolicy::class,
        Models\Theatre::class => Policies\TheatrePolicy::class,
        Models\TimeSlot::class => Policies\SlotPolicy::class,
        Models\Show::class => Policies\ShowPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->commands([
            \Laravel\Passport\Console\InstallCommand::class,
            \Laravel\Passport\Console\ClientCommand::class,
            \Laravel\Passport\Console\KeysCommand::class,
        ]);

        Passport::tokensExpireIn(now()->addDays(1));

        Passport::refreshTokensExpireIn(now()->addDays(2));
    }
}
