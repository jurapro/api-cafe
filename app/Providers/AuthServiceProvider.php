<?php

namespace App\Providers;

use App\Exceptions\ApiException;
use App\Models\Order;
use App\Models\User;
use App\Models\WorkShift;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Integer;
use function Symfony\Component\String\u;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
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

        Gate::define('orders-workShift', function (User $user, WorkShift $workShift) {
            return $user->hasRole(['admin']) || $workShift->hasUser($user->id);
        });

        Gate::define('store-order', function (User $user, WorkShift $workShift) {
            return $workShift->hasUser($user->id);
        });

        Gate::define('show-order', function (User $user, Order $order) {
            return $user->hasRole(['admin']) || $order->worker->user->id === $user->id;
        });

        Gate::define('changeStatus-order', function (User $user, Order $order) {
            return $user->hasRole(['cook']) || $order->worker->user->id === $user->id;
        });

        Gate::define('allowStatus-order', function (User $user, Order $order, $status) {
            return in_array($status, $order->getAllowedsTransitions($user));
        });

        Gate::define('update-position-order', function (User $user, Order $order) {
            return $order->worker->user->id === $user->id;
        });


    }
}
