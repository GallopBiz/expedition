<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpeditingEquipment extends Model
{
    use HasFactory;
    protected $table = 'expediting_equipments';
    protected $fillable = [
        'expediting_form_id', 'name', 'design', 'material', 'fab', 'fat', 'status', 'subsupplier', 'qty', 'place', 'order_status', 'drawing', 'scope', 'start', 'end', 'duration', 'fatdate', 'contractualdate', 'actualdate', 'openpoints', 'remarks', 'checks'
    ];
    protected $casts = [
        'checks' => 'array',
        'start' => 'date',
        'end' => 'date',
        'fatdate' => 'date',
        'contractualdate' => 'date',
        'actualdate' => 'date',
    ];

    public function form()
    {
        return $this->belongsTo(ExpeditingForm::class, 'expediting_form_id');
    }
}
