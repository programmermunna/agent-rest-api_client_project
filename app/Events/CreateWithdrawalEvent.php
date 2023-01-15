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

class CreateWithdrawalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $withdraw;
    public $notify;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WithdrawModel $withdraw)
    {
        $notify = WithdrawModel::select('id')->where('approval_status', 0)->count();
        $this->withdraw = $withdraw;
        $this->notify = $notify > 9 ? '9+' : $notify;
    }

    public function broadcastOn()
    {
        return [
            new Channel('MemberSocket-Channel-Withdraw-'.$this->withdraw->members_id),
            new Channel('MemberSocket-Channel-Withdraw'),
        ];
    }

    public function broadcastAs()
    {
        return 'MemberSocket-Event-Withdraw-CreateWithdraw';
    }
}
