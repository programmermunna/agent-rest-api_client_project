<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaintenanceStatusUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private bool $maintenanceStatus;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(bool $status)
    {
        $this->maintenanceStatus = $status;
    }

    public function getMaintenanceStatus(): bool
    {
        return $this->maintenanceStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new Channel("maintenance.status"),
            new Channel("all.auth.users")
        ];
    }

    public function broadcastAs(): string
    {
        return 'maintenance.status';
    }

    public function broadcastWith(): array
    {
        return [
            'status' => $this->maintenanceStatus
        ];
    }
}
