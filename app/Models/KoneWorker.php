<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoneWorker extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'kone_workers';

    protected $fillable = [
        'name',
        'tel',
        'position',
        'supervisor',
    ];


}
