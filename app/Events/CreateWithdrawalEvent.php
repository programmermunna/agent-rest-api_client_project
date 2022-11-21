<?php

namespace App\Events;

use App\Models\WithdrawModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateWithdrawalEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private WithdrawModel $withdrawModel;
    protected bool $emitAble;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WithdrawModel $withdrawModel, bool $emitAble = true)
    {
        $this->withdrawModel = $withdrawModel;
        $this->emitAble = $emitAble;
    }

    public function getWithdrawModel(): WithdrawModel
    {
        return $this->withdrawModel;
    }

    public function getEmitAble(): bool
    {
        return $this->emitAble;
    }
}
