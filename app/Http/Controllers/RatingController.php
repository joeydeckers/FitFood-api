<?php

namespace App\Http\Controllers;
use App\Rating;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function createRating(Request $request, $id){
        $rules = [
            'rating' => 'required',
            'owner_id' => 'required',
        ];

        return Rating::create([
            'rating' => $request['rating'],
            'recipe_id' => $id,
            'owner_id' => $request['owner_id']
        ]);
    }
}
