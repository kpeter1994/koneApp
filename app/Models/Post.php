<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'posts';

    protected $fillable = [
        'slug',
        'title',
        'user_id',
        'body',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Kizárhatod a nagy méretű mezőket
        unset($array['large_text_field']);

        // Vagy átalakíthatod őket
        $array['content'] = substr($this->content, 0, 500); // csak az első 500 karakter

        return $array;
    }


}
