<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetDefaultRoleListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // /**
    //  * Handle the event.
    //  *
    //  * @param  UserCreatedEvent  $event
    //  * @return void
    //  */
    // public function handle(UserCreatedEvent $event)
    // {
    //     $event->user->assignRole('client');
    // }
}
