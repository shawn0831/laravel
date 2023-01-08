<?php

namespace App\Mail;


use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// (implements ShouldQueue contract will always use queue when sending message)
class OrderShipped extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // View Data
    // =============================================================
    // Via Public Properties
    // public $order;
    // Via The with Method (protected or private)
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        // Configuring The Sender
        // =============================================================
        // Using The from Method
        return $this->from('example@example.com')
        ->view('emails.orders.shipped');

        // Configuring The View
        // =============================================================
        return $this->view('emails.orders.shipped');

        // Plain Text Emails (you can define both an HTML and plain-text version at the same time)
        return $this->view('emails.orders.shipped')
                    ->text('emails.orders.shipped_plain');

        // View Data
        // =============================================================
        // Via Public Properties
        return $this->view('emails.orders.shipped');

        // Via The with Method
        return $this->view('emails.orders.shipped')
                    ->with([
                        'orderName' => $this->order->name,
                        'orderPrice' => $this->order->price,
                    ]);
        
        // Attachments
        // =============================================================
        // attach method
        return $this->view('emails.orders.shipped')
                    ->attach('/path/to/file');

        return $this->view('emails.orders.shipped')
                    ->attach('/path/to/file',[
                        'as' => 'name.pdf',
                        'mime'=>'application/pdf'
                    ]);
        
        // Attaching Files from Disk
        // attachFromStorage method
        return $this->view('emails.orders.shipped')
                    ->attachFromStorage('/path/to/file');

        return $this->view('emails.orders.shipped')
                    ->attachFromStorage('/path/to/file','name.pdf',[
                        'mime' => 'application/pdf'
                    ]);
        // attachFromStorageDisk method ()
        return $this->view('emails.orders.shipped')
                    ->attachFromStorageDisk('s3','/path/to/file');

        // Raw Data Attachments
        return $this->view('emails.orders.shipped')
                    ->attachData($this->pdf,'name.pdf',[
                        'mime' => 'application/pdf'
                    ]);
        
        // Customizing The SwiftMailer Message
        // =============================================================
        return $this->view('emails.orders.shipped');
        
        return $this->withSwiftMessage(function($message){
            $message->getHeaders()
                    ->addTextHeader('Custom-Header','HeaderValue');
        });

        // Rendering Mailables (use in controller)
        // =============================================================
        $invoice = App\Invoice::find(1);
        
        return (new App\Mail\InvoicePaid($invoice))->render();

        // Previewing Mailables In The Browser
        return new App\Mail\InvoicePaid($invoice);

        
    }

}
