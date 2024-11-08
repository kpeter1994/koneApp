<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MolCharger extends Model
{
    use HasFactory;

    protected $table = 'mol_charger';

    protected $primaryKey = 'id';


    protected $fillable = [
        'charger_id',
        'model_name',
        'name',
        'mol_service_id',
        'site_name',
        'address',
        'speed',
        'access',
        'route_password'
    ];

    public function molService()
    {
        return $this->belongsTo(MolService::class);
    }
}
