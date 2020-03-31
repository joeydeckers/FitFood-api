<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeLinking extends Model
{
    protected $fillable = [
        'recipe_id',
        'mealprep_id',
    ];
}
