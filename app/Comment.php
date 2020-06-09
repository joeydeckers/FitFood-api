<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment_text',
        'owner_id',
        'recipe_id',
    ];
    
}
