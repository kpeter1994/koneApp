<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'work_order';

    protected $fillable = [
        'worker_id',
        'status',
        'start_status',
        'end_status',
    ];

    public $timestamps = false;

    public function worker()
    {
        return $this->belongsTo(KoneWorker::class, 'worker_id');
    }
}
