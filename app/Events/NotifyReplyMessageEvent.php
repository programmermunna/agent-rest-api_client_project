<?php

namespace App\Events;

use App\Models\MemoModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyReplyMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $memo;
    public $notify;
    protected $emitABle;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MemoModel $memoModel, bool $emitABle = true)
    {
        $notify = MemoModel::where('is_read', false)->where('send_type', 'Member')->count();
        $this->memo = $memoModel;
        $this->notify = $notify > 9 ? '9+' : $notify;
        $this->emitABle = $emitABle;
    }

    public function getMemo()
    {
        return $this->memo;
    }

    public function emitAble()
    {
        return $this->emitABle;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("MemberSocket-Channel-Message");
    }

    public function broadcastAs()
    {
        return 'MemberSocket-Event-Message-ReplayMessage';
    }
}
