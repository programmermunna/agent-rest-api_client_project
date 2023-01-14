<?php

namespace App\Providers;

use App\Domains\Auth\Listeners\RoleEventListener;
use App\Domains\Auth\Listeners\UserEventListener;
use App\Events\BetTogelBalanceEvent;
use App\Events\CreateDepositEvent;
use App\Events\CreateWithdrawalEvent;
use App\Events\LastBetWinEvent;
use App\Events\MaintenanceStatusUpdate;
use App\Events\NotifyNewMemo;
use App\Events\NotifyReadMessageEvent;
use App\Events\NotifyReplyMessageEvent;
use App\Events\WithdrawalCreateBalanceEvent;
use App\Listeners\BetTogelBalanceEventListener;
use App\Listeners\CreateDepositEventListener;
use App\Listeners\CreateWithdrawalEventListener;
use App\Listeners\DispatchNewMemoEventToExternalService;
use App\Listeners\LastBetWinListener;
use App\Listeners\MaintenanceStatusUpdateListener;
use App\Listeners\NotifyReadMessageEventListener;
use App\Listeners\NotifyReplyMessageEventListener;
use App\Listeners\WithdrawalCreateBalanceEventListener;
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
        NotifyNewMemo::class => [
            DispatchNewMemoEventToExternalService::class,
        ],
        NotifyReplyMessageEvent::class => [
            NotifyReplyMessageEventListener::class,
        ],
        NotifyReadMessageEvent::class => [
            NotifyReadMessageEventListener::class,
        ],
        MaintenanceStatusUpdate::class => [
            MaintenanceStatusUpdateListener::class,
        ],
        CreateDepositEvent::class => [
            CreateDepositEventListener::class,
        ],
        CreateWithdrawalEvent::class => [
            CreateWithdrawalEventListener::class,
        ],
        WithdrawalCreateBalanceEvent::class => [
            WithdrawalCreateBalanceEventListener::class,
        ],
        BetTogelBalanceEvent::class => [
            BetTogelBalanceEventListener::class,
        ],
        LastBetWinEvent::class => [
            LastBetWinListener::class,
        ],
        // WEB SOCKET FINISH
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
