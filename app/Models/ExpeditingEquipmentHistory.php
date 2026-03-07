<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingEquipmentHistory extends Model
{
    protected $fillable = [
        'expediting_equipment_id',
        'field_changed',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
        'ip_address',
    ];
    public $timestamps = false;

    public function equipment()
    {
        return $this->belongsTo(ExpeditingEquipment::class, 'expediting_equipment_id');
    }
}
