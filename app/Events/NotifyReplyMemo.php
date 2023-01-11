<?php

namespace App\Events;

use App\Models\MemoModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyReplyMemo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $memo;
    protected $emitABle;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MemoModel $memoModel, bool $emitABle = true)
    {
        $this->memo = $memoModel;
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
     * @return Channel|array
     */
    public function broadcastOn()
    {
        Log::info("broadcast intiated");
        //@todo for some reasons it needs more than 1 channel before it works
        return [
            new Channel("test"),
            new Channel("MemberSocket-Channel-Message")
        ];
    }

    public function broadcastAs()
    {
        return 'MemberSocket-Event-Message-ReplayMessage';
    }
}
