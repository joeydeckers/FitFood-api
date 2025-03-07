<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name', 'description', 'wheat_allergy', 'milk_allergy', 'allergies_list', 'owner_id', 'votes_id', 'comments_id', 'category_time', 'recipe_photo', 'photo_path',
        'protein', 'carbs', 'fats', 'calories'
    ];

    public function user(){
        return $this->hasOne('App\User');
    }

    public function comment(){
        return $this->hasMany('App\Comment');
    }

    public function rating(){
        return $this->hasMany('App\Rating');
    }
}
