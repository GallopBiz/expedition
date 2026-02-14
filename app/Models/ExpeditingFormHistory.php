<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditingFormHistory extends Model
{
    protected $fillable = [
        'expediting_form_id',
        'field_changed',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
    ];
    public $timestamps = false;

    public function form()
    {
        return $this->belongsTo(ExpeditingForm::class, 'expediting_form_id');
    }
}
