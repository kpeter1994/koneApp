<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'equipments';

    protected $fillable = [
        'contract_ref',
        'name',
        'address',
        'type',
        'equipment',
        'emi',
        'worker',
        'supervisor',
        'rated_load',
        'inventory_number',
        'comment',
    ];
}
