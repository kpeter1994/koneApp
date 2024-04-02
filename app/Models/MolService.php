<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MolService extends Model
{
    use HasFactory;

    protected $table = 'mol_service';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
    ];
}
