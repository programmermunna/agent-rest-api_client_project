<?php

namespace App\Events;

use App\Models\DepositModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateDepositEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // private DepositModel $deposit;

    // protected bool $emitAble = true;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DepositModel $deposit, bool $emitAble = true)
    {
        // $this->deposit = $deposit;
        // $this->emitAble = $emitAble;
    }

    public function getDeposit(): DepositModel
    {
        // return $this->deposit;
    }

    public function getEmitAble(): bool
    {
        // return $this->emitAble;
    }
}
