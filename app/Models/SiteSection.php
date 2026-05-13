<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'body',
        'extra',
    ];

    protected $casts = [
        'extra' => 'array',
    ];
}
