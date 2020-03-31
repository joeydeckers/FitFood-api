<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mealprep;
use App\Recipelinking;
use App\Recipe;

class MealprepController extends Controller
{
    public function createMealprep(Request $request){
        $rules = [
            'day' => 'required',
            'description' => 'required',
            'owner_id' => 'required',
            'recipes_id' => 'required'
        ];

        $recipes = explode(",", $request['recipes_id']);

        $countMealpreps = count(Mealprep::all());

        foreach($recipes as $recipe){
            $recipeLinkingId = Recipelinking::create([
                'recipe_id' => $recipe,
                'mealprep_id' => $countMealpreps+1,
            ]);
        }

        return Mealprep::create([
            'day' => $request['day'],
            'description' => $request['description'],
            'owner_id' => $request['owner_id'],
            'recipe_linking_table_id' => $countMealpreps+1,
        ]);
    }

    public function getMealprep($id){
        $mealprep = Mealprep::findOrFail($id);
        $recipe_linking_table_id = $mealprep->recipe_linking_table_id;
        $recipe_ids = Recipelinking::where('mealprep_id', $recipe_linking_table_id)->get();
        
        $recipes = [];

        foreach($recipe_ids as $recipe_id){
            $recipe = Recipe::where('id', $recipe_id->recipe_id)->get();
            array_push($recipes, $recipe);
        }

        return response(['mealprep'=> $mealprep, 'recipes' => $recipes],200);
        
    }
}
