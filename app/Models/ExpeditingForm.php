<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingForm extends Model
{
    //
    protected $fillable = [
        'work_package',
        'lli',
        'expediting_category',
        'workpackage_name',
        'supplier',
        'order_date',
        'contract_data_available_dmcs',
        'po_number',
        'incoterms',
        'exyte_procurement_contract_manager',
        'customer_procurement_contact',
        'kickoff_status',
        'technical_workpackage_owner',
        'workstream_building',
        'expediting_contact',
        'created_by',
    ];
}
