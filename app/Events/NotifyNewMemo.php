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

class NotifyNewMemo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $memo;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MemoModel $memoModel)
    {
        $this->memo = $memoModel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("App.Models.MembersModel.{$this->memo->member_id}");
    }
}
