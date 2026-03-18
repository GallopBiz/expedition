<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpeditingEquipment extends Model
{
    use HasFactory;
    protected $table = 'expediting_equipments';
    protected $fillable = [
        'expediting_form_id', 'context_id', 'name', 'design', 'material', 'fab', 'fat', 'status', 'subsupplier', 'qty', 'place', 'order_status', 'drawing', 'scope', 'start', 'end', 'duration', 'fatdate', 'contractualdate', 'actualdate', 'neededsite', 'openpoints', 'remarks', 'checks'
    ];
    protected $casts = [
        'checks' => 'array',
        'start' => 'date',
        'end' => 'date',
        'fatdate' => 'date',
        'contractualdate' => 'date',
        'actualdate' => 'date',
        'neededsite' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::updating(function ($equipment) {
            $original = $equipment->getOriginal();
            $changes = $equipment->getDirty();
            foreach ($changes as $field => $newValue) {
                $oldValue = $original[$field] ?? null;
                // Encode arrays as JSON for DB storage
                if (is_array($oldValue)) {
                    $oldValue = json_encode($oldValue);
                }
                if (is_array($newValue)) {
                    $newValue = json_encode($newValue);
                }
                \App\Models\ExpeditingEquipmentHistory::create([
                    'expediting_equipment_id' => $equipment->id,
                    'field_changed' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'changed_by' => auth()->user()->name ?? 'system',
                    'changed_at' => now(),
                ]);
            }
        });
    }

    public function form()
    {
        return $this->belongsTo(ExpeditingForm::class, 'expediting_form_id');
    }
}
