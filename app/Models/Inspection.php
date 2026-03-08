<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = 'inspections';
    protected $fillable = [
        'context_id',
        'inspection_date',
        'inspection_for',
        'inspection_location',
        'user_id',
        'files',
    ];
        public function context()
        {
            return $this->belongsTo(ExpeditingContext::class, 'context_id');
        }
    protected $casts = [
        'files' => 'array',
        'inspection_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
