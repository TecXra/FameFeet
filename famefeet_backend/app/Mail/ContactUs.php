<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $contactUs;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactUs)
    {
        $this->contactUs = $contactUs;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if(config('famefeet.app_env') == 'production'){
            $subject = "Contact Us :: ".$this->contactUs->subject;
         }else{
           $subject = "Contact Us :: Test Email :: ".$this->contactUs->subject;
         }
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.contactus',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
