<?php

namespace App\Listeners;

use App\Events\MemberLeft;
use App\Minute;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SumTime
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
     * @param  MemberLeft  $event
     * @return void
     */
    public function handle(MemberLeft $event)
    {
        Minute::keep($event->member, $event->visitlog);
    }
}
