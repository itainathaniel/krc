<?php

namespace App\Listeners;

use App\Events\newKnessetMember;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailItai
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
     * @param  newKnessetMember  $event
     * @return void
     */
    public function handle(newKnessetMember $event)
    {
        //
    }
}
