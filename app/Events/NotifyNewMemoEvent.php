<?php

namespace App\Events;

use App\Models\MemoModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyNewMemoEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $memo;
    public $notify;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($memo)
    {
        $notify = MemoModel::where('is_read', false)->whereIn('send_type', ['System', 'Admin'])->where('member_id', $memo->member_id)->count();
        $this->memo = $memo;
        $this->notify = $notify > 9 ? '9+' : $notify;
        $this->emitABle = $emitABle;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("MemberSocket-Channel-Message-{$this->memo->member_id}");
    }

    public function broadcastAs()
    {
        return 'MemberSocket-Event-Message-CreateMessage';
    }
}
