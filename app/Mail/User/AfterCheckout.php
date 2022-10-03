<?php

namespace App\Mail\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Checkout;

class AfterCheckout extends Mailable
{
    use Queueable, SerializesModels;

    private $checkout;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Register Camp: {$this->checkout->Camp->title}")
            ->markdown('emails.user.afterCheckout', [
                'checkout' => $this->checkout
            ]);
    }
}
