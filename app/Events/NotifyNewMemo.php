<?php

namespace App\Events;

use App\Models\MemoModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
     * @return Channel|array
     */
    public function broadcastOn()
    {
        //Log::info('broadcasted');
        return new Channel("App.Models.MembersModel.{$this->memo->member_id}");
    }
}
