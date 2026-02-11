<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingForm extends Model
{
    protected $fillable = [
        'context_id',
        'work_package',
        'workstream_building',
        'expediting_contact',
        'created_by',
        'expediting_category',
        'workpackage_name',
        'supplier',
    ];

    public function context()
    {
        return $this->belongsTo(ExpeditingContext::class, 'context_id');
    }
}
