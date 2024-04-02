<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusEvent extends Model
{
    use HasFactory;
    protected $table = 'bus_event';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'daily_report_id',
        'description',
        'time',
        'location',
        'reporter',
        'notified',
        'recorder',
        'damage_value'
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }
}
