<?php

namespace App\Console\Commands;

use App\Member;
use Illuminate\Console\Command;

class RollCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'krc:rollcall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a roll-call round and see who\'s in and who\'s out.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $members = Member::where('active', true)
            ->get()
            ->filter(function($member) {
                $knessetmember = Member::fetchFromTheKnesset($member->knesset_id);

                if (!($member instanceof Member) || !$member->exists) {
                    return false;
                }

                $this->line("member {$member->present} and knessetmember {$knessetmember->present}");
                if ($member->present == $knessetmember->present) {
                    return false;
                }

                return true;
            })->each(function($member){
                $member->usedTheDoor();

                $this->info($member->name_english . ' used the door');
            });

        $this->comment($members->count() . ' user(s) used the door');
    }
}
