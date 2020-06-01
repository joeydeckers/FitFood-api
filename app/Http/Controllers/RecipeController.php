<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\User;
use App\Rating;
use App\Comment;
use Validator;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'calories' => 'required',
            'protein'=> 'required',
            'carbs'=> 'required',
            'fats'=> 'required',
            'category_time' => 'required',
            'recipe_photo' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);


        $image = $request->recipe_photo;  // your base64 encoded
        $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image, 0, strpos($image, ',')+1); 
        
        // find substring fro replace here eg: data:image/png;base64,
        
        $image = str_replace($replace, '', $image); 
        
        $image = str_replace(' ', '+', $image); 
        
        $imageName = Str::random(10).'.'.$extension;
        Storage::disk('recipe_img')->put($imageName, base64_decode($image));
        // voor heroku
        $path = "https://fitfood-api.herokuapp.com/uploads/".$imageName;
        // voor lokaal
        //$path = public_path("/uploads/").$imageName;	
        return Recipe::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'photo_path' => $path,
            //'photo_path' => "http://via.placeholder.com/1920",
            'wheat_allergy' => $request['wheat_allergy'],
            'milk_allergy' => $request['milk_allergy'],
            'allergies_list' => $request['allergies_list'],
            'protein' => $request['protein'],
            'calories' => $request['calories'],
            'carbs' => $request['carbs'],
            'fats' => $request['fats'],
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
        $comments = Comment::where('recipe_id', $recipe->id)->get();
        $rating = Rating::where('recipe_id', $recipe->id)->get();
        $numberOfRatings = count($rating);
        
        $allRatingCount = 0;
        foreach($rating as $ratingCount){
            $allRatingCount += $ratingCount->rating;
        }

        if($allRatingCount == 0){
            return response(['recipe' => $recipe, 'user' => $user, 'comments' => $comments, 'rating' => 0], 200);
        }
        $definiteRating =  $allRatingCount / $numberOfRatings;

        return response(['recipe' => $recipe, 'user' => $user, 'comments' => $comments, 'rating' => $definiteRating], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRecipe(Request $request, $id)
    {

        
        $user = auth()->guard('api')->user();
        $recipe = Recipe::where('owner_id',$user->id)->where('id', $id)->first();

        if(is_null($recipe)){
            return response(['message' => "Not found"], 404);
        }

        $recipe->update($request->all());

        if($request['recipe_photo']){
            $image = $request->recipe_photo;  // your base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
    
            $replace = substr($image, 0, strpos($image, ',')+1); 
            
            // find substring fro replace here eg: data:image/png;base64,
            
            $image = str_replace($replace, '', $image); 
            
            $image = str_replace(' ', '+', $image); 
            
            $imageName = Str::random(10).'.'.$extension;
            Storage::disk('recipe_img')->put($imageName, base64_decode($image));
            // voor heroku
            $path = "https://fitfood-api.herokuapp.com/uploads/".$imageName;
            $recipe->photo_path = $path;
        }
        return $recipe;
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
        if($recipe[0]->owner_id == $user->id){
            Recipe::destroy($id);
        }
        
        return response(['Message' => "Recipe deleted!"], 200);
    }

    public function getRecipeByDayTime($daytime){
        $recipe = Recipe::where('category_time', $daytime)->get();

        if(is_null($recipe)){
            return response(['message' => "Not found"], 404);
        }

        return response($recipe, 200);
    }


    // hier moet goed naar gekeken worden
    public function recipeFilter(Request $request){

        // if(is_null($request['category_time'])){
        //     $recipe = Recipe::where('protein', '>=', $request['protein'])
        //     ->where('carbs', '<=', $request['carbs'])
        //     ->where('fats', '<=', $request['fats'])
        //     ->where('calories', '<=', $request['calories'])
        //     ->get();
        //     return $recipe;
        // }
        
        if($request['protein']){
            $recipe = Recipe::where('protein', '<=', $request['protein'])
                // ->where('carbs', '<=', $request['carbs'])
                // ->where('fats', '<=', $request['fats'])
                // ->where('calories', '<=', $request['calories'])
                ->get();



            return $recipe;
        }


    }
}
