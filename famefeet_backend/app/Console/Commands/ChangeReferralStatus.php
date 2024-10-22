<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Services\ReferralUserService;

class ChangeReferralStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:referral_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command check the availability of referral bonus for the refer user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking referral user date !');
        $this->info('Please wait.....');
        $result = ReferralUserService::changeReferralStatus();
        return $result;
    }
}
