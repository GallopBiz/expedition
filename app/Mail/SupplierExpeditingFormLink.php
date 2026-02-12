<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierExpeditingFormLink extends Mailable
{
    use Queueable, SerializesModels;

    public $supplierName;
    public $formLink;
    public $form;

    public function __construct($supplierName, $formLink, $form)
    {
        $this->supplierName = $supplierName;
        $this->formLink = $formLink;
        $this->form = $form;
    }

    public function build()
    {
        return $this->subject('Expediting Form Submission Link')
            ->markdown('emails.supplier_expediting_form_link');
    }
}
