<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendFeedback extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $message;
    public $vendor_email;
    public $vendor_name;
    public $restaurant_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$vendor_email)
    {
        $this->restaurant_name = $data['restaurant_name'];
        $this->vendor_name = $data['vendor_name'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->message = $data['message'];
        $this->vendor_email = $vendor_email;
    }
    public function build()
    {
        return $this->view('emails.feedback')
            ->subject(__('system.feedbacks.feedback_received'))
            ->to($this->vendor_email)
            ->with([
                'name' => $this->name,
                'restaurant_name' => $this->restaurant_name,
                'vendor_name' => $this->vendor_name,
                'email' => $this->email,
                'user_message' => $this->message,
            ]);
    }
}
