<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'creator_id',
        'feed_id',
        'message'
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
