<?php

namespace App\Listeners;

use App\Events\crudEvent;
use App\Models\Boilerplate\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class crudEventNoti
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

    /**
     * Handle the event.
     *
     * @param  crudEvent  $event
     * @return void
     */
    public function handle(crudEvent $event)
    {
        $user = User::find($event->user);
        $message = $event->message;
        Log::channel('crud')->info($user->user_name . $message .' at ' . date('Y-m-d H:i:s'));
    }
}
