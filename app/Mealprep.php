<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mealprep extends Model
{
    protected $fillable = [
        'day',
        'description',
        'owner_id',
        'recipe_linking_table_id'
    ];

    // public function user(){
    //     return $this->hasOne('App\User');
    // }

}
