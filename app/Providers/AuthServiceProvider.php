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
        'App\Models\Radio' => 'App\Policies\RadioPolicy',
        'App\Models\Activity' => 'App\Policies\ActivityPolicy',
        'App\Models\Student' => 'App\Policies\StudentPolicy',
        'App\Models\Teacher' => 'App\Policies\TeacherPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
