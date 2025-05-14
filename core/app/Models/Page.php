<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $casts = [
        'seo_content' => 'object'
    ];
    
    protected $fillable = [
        'slug',       // Add this
        'title',      // Add this
        'content',    // Add this
        'seo_content' // Add this
    ];
}