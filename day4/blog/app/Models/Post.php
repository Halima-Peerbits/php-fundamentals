<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // allow mass assignment for these fields
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

