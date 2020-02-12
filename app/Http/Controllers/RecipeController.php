<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return $recipe;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
