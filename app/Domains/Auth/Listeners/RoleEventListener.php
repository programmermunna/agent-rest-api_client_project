<?php

namespace App\Domains\Auth\Listeners;

use App\Domains\Auth\Events\Role\RoleCreated;
use App\Domains\Auth\Events\Role\RoleDeleted;
use App\Domains\Auth\Events\Role\RoleUpdated;

/**
 * Class RoleEventListener.
 */
class RoleEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('role')
            ->performedOn($event->role)
            ->withProperties([
                'role' => [
                    'type' => $event->role->type,
                    'name' => $event->role->name,
                ],
                'target' => $event->role->name,
                'activity' => 'Create admin level ' ,
                'permissions' => $event->role->permissions->count() ? $event->role->permissions->pluck('description')->implode(', ') : 'None',
            ])
            ->log('With permissions: :properties.permissions');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('role')
            ->performedOn($event->role)
            ->withProperties([
                'role' => [
                    'type' => $event->role->type,
                    'name' => $event->role->name,
                ],
                'target' => $event->role->name,
                'activity' => 'Update admin level ' ,
                'permissions' =>$event->role->permissions->count() ? $event->role->permissions->pluck('description')->implode(', ') : 'None',
            ])
            ->log('with permissions: :properties.permissions');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('role')
            ->performedOn($event->role)
            ->withProperties([
                'target' => $event->role->name,
                'activity' => 'Delete admin level' ,
            ])
            ->log('Successfully');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            RoleCreated::class,
            'App\Domains\Auth\Listeners\RoleEventListener@onCreated'
        );

        $events->listen(
            RoleUpdated::class,
            'App\Domains\Auth\Listeners\RoleEventListener@onUpdated'
        );

        $events->listen(
            RoleDeleted::class,
            'App\Domains\Auth\Listeners\RoleEventListener@onDeleted'
        );
    }
}
