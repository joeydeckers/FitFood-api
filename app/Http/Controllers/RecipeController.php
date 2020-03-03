<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\User;
use Validator;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::all();
        return $recipes;
    }


    public function getRecipeByWheatAllergy(){
        $recipe = Recipe::all()->where('wheat-allergy', '1')->get();
        return $recipe;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRecipe(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'wheat_allergy' => 'required',
            'milk_allergy' => 'required',
            'allergies_list' => 'required',
            'owner_id' => 'required',
            'votes_id' => 'required',
            'comments_id' => 'required',
            'category_time' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        return Recipe::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'photo_path' => 'testPath',
            'wheat_allergy' => $request['wheat_allergy'],
            'milk_allergy' => $request['milk_allergy'],
            'allergies_list' => $request['allergies_list'],
            'owner_id' => $request['owner_id'],
            'votes_id' => $request['votes_id'],
            'comments_id' => $request['comments_id'],
            'category_time' => $request['category_time'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRecipe($id)
    {
        $recipe = Recipe::findOrFail($id);
        $user = User::find($recipe->owner_id);
        return response(['recipe' => $recipe, 'user' => $user], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRecipe($id)
    {
        $user = auth()->guard('api')->user();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRecipe($id)
    {
        $user = auth()->guard('api')->user();

        $recipe = Recipe::where('owner_id',$user->id)->where('id', $id)->get();
        $recipe->delete();
        return response(['Message' => "Recipe deleted!"], 200);
    }
}
