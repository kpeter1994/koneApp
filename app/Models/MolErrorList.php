<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MolErrorList extends Model
{
    use HasFactory;

    protected $table = 'mol_error_list';


    protected $fillable = [
        'code',
        'name',
        'description',
        'message',
        'seriousness1',
        'seriousness2',
        'optional_solution'
    ];
}
