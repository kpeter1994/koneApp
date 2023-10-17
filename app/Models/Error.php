<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;

    protected $table = 'error';

    protected $fillable = [
        'error_number',
        'equipment_id',
        'description',
        'error_type',
        'isStand',
        'injured',
        'dispatcher',
        'whistleblower',
        'whistleblower_tel',
        'comment',
        'troubleshooter'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
