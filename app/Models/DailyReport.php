<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'daily_reports';

    protected $fillable = [
        'dispatcher',
        'actual',
        'info_error',
        'firewall_attack',
        'd_solo_demand',
        'd_articulated_demand',
        'd_solo_supply',
        'd_articulated_supply',
        'b_solo_demand',
        'b_articulated_demand',
        'b_solo_supply',
        'b_articulated_supply',
        'k_solo_demand',
        'k_articulated_demand',
        'k_sprinter_demand',
        'k_solo_supply',
        'k_articulated_supply',
        'k_sprinter_supply',
        'd_start_worker',
        'd_middle_worker',
        'd_end_worker',
        'b_start_worker',
        'b_middle_worker',
        'b_end_worker',
        'k_start_worker',
        'k_middle_worker',
        'k_end_worker',
    ];

    public function busEvents()
    {
        return $this->hasMany(BusEvent::class);
    }
}
