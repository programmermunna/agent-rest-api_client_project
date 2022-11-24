<?php

namespace App\Providers;

use App\Domains\Auth\Listeners\RoleEventListener;
use App\Domains\Auth\Listeners\UserEventListener;
// WEB SOCKET START
// use App\Events\CreateDepositEvent;
// use App\Events\CreateWithdrawalEvent;
// use App\Events\MaintenanceStatusUpdate;
// use App\Events\MemberUpdate;
// use App\Events\NotifyNewMemo;
// use App\Listeners\DispatchNewMemoEventToExternalService;
// use App\Listeners\CreateDepositEventListener;
// use App\Listeners\CreateWithdrawalEventListener;
// use App\Listeners\MemberUpdateListener;
// use App\Listeners\MaintenanceStatusUpdateListener;
// WEB SOCKET END
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // WEB SOCKET START
        // NotifyNewMemo::class => [
        //     DispatchNewMemoEventToExternalService::class
        // ],
        // MemberUpdate::class => [
        //     MemberUpdateListener::class
        // ],
        // MaintenanceStatusUpdate::class => [
        //     MaintenanceStatusUpdateListener::class
        // ],
        // CreateDepositEvent::class => [
        //     CreateDepositEventListener::class
        // ],
        // CreateWithdrawalEvent::class => [
        //     CreateWithdrawalEventListener::class
        // ]
        // WEB SOCKET END
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        RoleEventListener::class,
        UserEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
