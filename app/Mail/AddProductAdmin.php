<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Product;

class AddProductAdmin extends Mailable
{
    use Queueable, SerializesModels;
    protected $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product= $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //print_r($this->product);
        //exit();
        return $this->view('emails.addproduct')->with([
            'productId' => $this->product->id,
            'productName' => $this->product->name,
            'url' => config('constants.BASE_PATH')
        ]);
    }
}
