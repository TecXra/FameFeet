<?php

namespace App\Console\Commands;

use App\Mail\ContactUs as MailContactUs;
use Mail;
use App\Models\ContactUs;
use Illuminate\Console\Command;

class EmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {to} {subject} {body}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to test Email service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contactUs = new ContactUs();
        $contactUs->name = 'Asif Sharif Shahid';
        $contactUs->email = $this->argument('to');
        $contactUs->subject = $this->argument('subject');
        $contactUs->message = $this->argument('body');

        $environment = \App::environment();

        $contactUs->subject = $contactUs->subject . ' :: ' . $environment;
        $contactUs->save();

        Mail::to($this->argument('to'))->send(new MailContactUs($contactUs));


        // Mail::raw($this->argument('body'), function ($message) {
        //   $message->to($this->argument('to'))
        //     ->subject($this->argument('subject'));
        // });

        return Command::SUCCESS;
    }
}
