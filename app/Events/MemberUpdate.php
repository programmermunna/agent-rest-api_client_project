<?php

namespace App\Events;

use App\Models\MembersModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MemberUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private MembersModel $member;
    public bool $emitAble = true;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MembersModel $member, bool $emitAble = true)
    {
        $this->member = $member;
    }

    public function getMember(): MembersModel
    {
        return $this->member;
    }

    public function getEmitAble(): bool
    {
        return $this->emitAble;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return  [
            new Channel("test"),
            new Channel("App.Models.MembersModel.{$this->member->id}")
        ];
    }

    public function broadcastAs(): string
    {
        return 'New-Balance-Member';
    }

    public function broadcastWith(): array
    {
        return [
            'member' => $this->member
        ];
    }
}
