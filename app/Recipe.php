<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name', 'description', 'wheat_allergy', 'milk_allergy', 'allergies_list', 'owner_id', 'votes_id', 'comments_id'
    ];

    public function user(){
        return $this->hasOne('App\User');
    }
}
