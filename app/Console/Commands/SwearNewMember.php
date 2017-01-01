<?php

namespace App\Console\Commands;

use App\Member;
use Exception;
use Illuminate\Console\Command;

class SwearNewMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'krc:swear {knesset_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swears new Knesset Member (to the website)';

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
        $member = Member::fetchFromTheKnesset($this->argument('knesset_id'));

        if ($member instanceof Exception) {
            $this->error('Exception: ' . $member->getMessage());

            return false;
        }

        if ($member instanceof Member && !$member->exists) {
            $member->save();

            $this->info('Knesset Member swore successfully!');

            return true;
        }

        $this->error('Nothing happenend');
    }
}
