<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallCenterReport extends Model
{
    use HasFactory;

    protected $table = 'call_center_reports';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'daily_report_id',
        'comment',
        'call_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
