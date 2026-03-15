<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialPlan extends Model
{
    protected $table = 'material_plans';
    protected $fillable = [
        'context_id',
        'contract_date',
        'first_handover_date',
        'last_date',
        'user_id',
        'files',
        'material_comment',
    ];
        public function context()
        {
            return $this->belongsTo(ExpeditingContext::class, 'context_id');
        }
    protected $casts = [
        'files' => 'array',
        'contract_date' => 'date',
        'first_handover_date' => 'date',
        'last_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
