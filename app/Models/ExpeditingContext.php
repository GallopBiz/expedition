<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingContext extends Model
{
    protected $fillable = [
        'supplier',
        'workpackage_name',
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
    ];

    public function executions()
    {
        return $this->hasMany(ExpeditingForm::class, 'context_id');
    }
}
