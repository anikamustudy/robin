<?php

namespace App\Providers;

use App\Repositories\Eloquent\BankRepository;
use App\Repositories\Eloquent\BankTypeRepository;
use App\Repositories\Eloquent\MembershipNotificationRepository;
use App\Repositories\Eloquent\MembershipRequestRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\ValuerRepository;
use App\Repositories\Interfaces\BankInterface;
use App\Repositories\Interfaces\BankTypeInterface;
use App\Repositories\Interfaces\MembershipNotificationInterface;
use App\Repositories\Interfaces\MembershipRequestInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\ValuerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(MembershipNotificationInterface::class, MembershipNotificationRepository::class);
        $this->app->bind(MembershipRequestInterface::class, MembershipRequestRepository::class);
        $this->app->bind(ValuerInterface::class, ValuerRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(BankInterface::class, BankRepository::class);
        $this->app->bind(BankTypeInterface::class,BankTypeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
