<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DbRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback migration, create migration, run seeder, install passport';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(' refreshing database migration and seeds !');
        $this->info('Please wait.........');

        $exitCode = Artisan::call('migrate:fresh',['--force'=>true, '--no-interaction'=>true]);
        $this->info('Freshing database migration done with exit code: ' . $exitCode);

        $exitCode = Artisan::call('db:seed',['--force'=>true, '--no-interaction'=>true]);
        $this->info('Seeding database  done with exit code: ' . $exitCode);


        $exitCode = Artisan::call('passport:client',['--personal'=>true, '--no-interaction'=>true]);
        $exitCode = Artisan::call('passport:client',['--password'=>true, '--no-interaction'=>true]);

        $this->info('Setting  Laravel Passport clients done with exit code: ' . $exitCode);

        $this->info(' Refreshing command done.........!!  :) ');
    }
}
