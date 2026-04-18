<?php
namespace App\Mail;
use Illuminate\Mail\Mailables\Address;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@simplestore.com', 'Simple Store'),
            subject: 'Order Confirmed #' . $this->order->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-placed',
        );
    }
}