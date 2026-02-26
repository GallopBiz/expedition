<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingContext extends Model
{
    protected $fillable = [
        'supplier',
        'workpackage_name',
        'work_package_no',
        'po_number',
        'lli',
        'expediting_category',
        'order_date',
        'contract_data_available_dmcs',
        'incoterms',
        'exyte_procurement_contract_manager',
        'customer_procurement_contact',
        'kickoff_status',
        'technical_workpackage_owner',
        'forecast_delivery_to_site',
        'workstream_building',
        'delivered',
    ];

    public function executions()
    {
        return $this->hasMany(ExpeditingForm::class, 'context_id');
    }
}
