<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingFormDateHistory extends Model
{
    protected $table = 'expediting_form_date_histories';
    public $timestamps = false;
    protected $fillable = [
        'expediting_form_id',
        'field',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
    ];

    public function expeditingForm()
    {
        return $this->belongsTo(ExpeditingForm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
