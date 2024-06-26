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

class CreateDepositEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $deposit;
    public $notify;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DepositModel $deposit)
    {
        $notify = DepositModel::select('id')->where('approval_status', 0)->count();
        $this->deposit = $deposit;
        $this->notify = $notify > 9 ? '9+' : $notify;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new Channel('MemberSocket-Channel-Deposit-'.$this->deposit->members_id),
            new Channel('MemberSocket-Channel-Deposit'),
        ];
    }
    
    public function broadcastAs()
    {
        return 'MemberSocket-Event-Deposit-CreateDeposit';
    }
}
