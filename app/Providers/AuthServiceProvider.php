<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\CaseDiary;
use App\Models\User;
use App\Policies\CaseDiaryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CaseDiary::class => CaseDiaryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Admin gate
        // This gate checks if the authenticated user's 'role' attribute is 'admin'.
        Gate::define('admin', function(User $user){
            return $user->role === 'admin';
        });

        // Optional: define gates for lawyer/staff permissions
        Gate::define('manage-staff', function(User $user){
            return in_array($user->role, ['admin','lawyer']);
        });

        Gate::define('chamber-access', function(User $user, $case){
            // Admin can access all
            if($user->role === 'admin') return true;
            // Only users in same chamber
            return $user->chamber_id === $case->chamber_id;
        });
    }
}
