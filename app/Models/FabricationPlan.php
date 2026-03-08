<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FabricationPlan extends Model
{
    protected $table = 'fabrication_plans';
    protected $fillable = [
        'context_id',
        'fabrication_contract_date',
        'fabrication_first_handover_date',
        'fabrication_last_update',
        'user_id',
        'files',
    ];
        public function context()
        {
            return $this->belongsTo(ExpeditingContext::class, 'context_id');
        }
    protected $casts = [
        'files' => 'array',
        'fabrication_contract_date' => 'date',
        'fabrication_first_handover_date' => 'date',
        'fabrication_last_update' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
