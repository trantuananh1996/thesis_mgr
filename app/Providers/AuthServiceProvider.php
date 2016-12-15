<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Permission;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        foreach ($this->getPermissions() as $permission)
        {

            $gate->define($permission->code, function ($user) use ($permission)
            {
                //return user có permission ko
                return $user->hasRole($permission->roles);
            });
        }

    }

    protected function getPermissions(){
        return Permission::with('roles')->get();
    }

}
