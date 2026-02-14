<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingFormEmailLog extends Model
{
    protected $table = 'expediting_form_email_logs';
    public $timestamps = false;
    protected $fillable = [
        'expediting_form_id',
        'recipient_email',
        'sent_by',
        'sent_at',
        'subject',
        'message',
    ];

    public function expeditingForm()
    {
        return $this->belongsTo(ExpeditingForm::class);
    }
}