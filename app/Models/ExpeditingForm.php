<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingForm extends Model
{
    public function actualDeliveryHistories()
    {
        return $this->hasMany(ExpeditingFormActualDeliveryHistory::class, 'expediting_form_id');
    }

    public function forecastDeliveryHistories()
    {
        return $this->hasMany(ExpeditingFormForecastDeliveryHistory::class, 'expediting_form_id');
    }
    protected $fillable = [
        'context_id',
        'work_package',
        'workstream_building',
        'expediting_contact',
        'created_by',
        'expediting_category',
        'workpackage_name',
        'supplier',
        'email_link_submitted',
        'equipment_type_tag_number',
        'detailed_scope_of_delivery',
        'quantity',
        'sub_supplier',
        'place_of_manufacturing',
        'order_status',
        'drawing_approval',
        'design_status',
        'material_status',
        'fabrication_status',
        'fat_status',
        'start_of_manufacturing_actual',
        'end_of_manufacturing',
        'fat_date_actual',
        'contractual_delivery_to_site_date',
        'actual_delivery_to_site_supplier',
        'forecast_delivery_to_site',
        'manufacturing_duration',
        'ready_for_shipment',
        'storage_at_supplier',
        'delivered',
        'comments',
    ];


    // Remove boolean cast for delivered

    // Accessor to always return Yes/No/other string for delivered
    public function getDeliveredAttribute($value)
    {
        if ($value === 1 || $value === '1') {
            return 'Yes';
        } elseif ($value === 0 || $value === '0') {
            return 'No';
        }
        return $value;
    }

    public function emailLogs()
    {
        return $this->hasMany(ExpeditingFormEmailLog::class, 'expediting_form_id');
    }

    public function dateHistories()
    {
        return $this->hasMany(ExpeditingFormDateHistory::class, 'expediting_form_id');
    }

    public function context()
    {
        return $this->belongsTo(ExpeditingContext::class, 'context_id');
    }
}
