<?php

namespace App\Events;

use App\Models\MemoModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyReadMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $memo;
    public $notify;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MemoModel $memoModel)
    {
        $notify = MemoModel::where('is_read', false)->whereIn('send_type', ['Admin','System'])->where('member_id', $memoModel->member_id)->count();
        $this->memo = $memoModel;
        $this->notify = $notify > 9 ? '9+' : $notify;
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
        return 'MemberSocket-Event-Message-ReadMessage';
    }
}
