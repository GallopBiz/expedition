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
        // Build subject: Exyte / PAR / 441 / MV Switchgear / Actemium / Expediting Follow-up
        $project = 'Exyte';
        $building = $this->form->workstream_building ?? null;
        $wpNo = $this->form->work_package_no ?? $this->form->workpackage_no ?? '';
        $wpName = $this->form->workpackage_name ?? '';
        $supplier = $this->form->supplier ?? $this->supplierName;
        $subject = $project;
        if ($building) {
            $subject .= ' / ' . $building;
        }
        $subject .= ' / ' . $wpNo . ' / ' . $wpName . ' / ' . $supplier . ' / Expediting Follow-up';
        return $this->subject($subject)
            ->markdown('emails.supplier_expediting_form_link');
    }
}
