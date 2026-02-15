<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingFormForecastDeliveryHistory extends Model
{
    protected $table = 'expediting_form_forecast_delivery_histories';
    public $timestamps = false;
    protected $fillable = [
        'expediting_form_id',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
    ];

    public function expeditingForm()
    {
        return $this->belongsTo(ExpeditingForm::class);
    }
}
