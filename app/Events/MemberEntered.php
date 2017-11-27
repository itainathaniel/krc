<?php

namespace App\Events;

use App\Member;
use App\VisitLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MemberEntered
{
    use InteractsWithSockets, SerializesModels;

    public $member;

    public $visitlog;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Member $member, VisitLog $log)
    {
        $this->member = $member;
        $this->visitlog = $log;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
