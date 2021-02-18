<?php

namespace App\Listeners;

use App\Events\GameStateUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateClient
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
     * @param  GameStateUpdated  $event
     * @return void
     */
    public function handle(GameStateUpdated $event)
    {
        //
    }
}
