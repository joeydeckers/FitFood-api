<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/recipes', 'RecipeController@index');
Route::get('/recipe/{id}', 'RecipeController@showRecipe');
Route::post('/recipe/create', 'RecipeController@createRecipe');
Route::get('/recipe/wheat-allergy', 'RecipeController@getRecipeByWheatAllergy');
Route::delete('/recipe/{id}', 'RecipeController@deleteRecipe');
Route::put('/recipe/{id}', 'RecipeController@editRecipe');
Route::get('/recipe/daytime/{daytime}', 'RecipeController@getRecipeByDayTime');
Route::post('/recipe/filter', 'RecipeController@recipeFilter');

route::post('/recipe/addcomment/{id}', 'CommentController@addComment');

route::post('/recipe/addrating/{id}', 'RatingController@createRating');

// user routes

Route::prefix('/user')->group(function(){
    Route::post('/login', 'UserController@login');
    Route::post('/register', 'UserController@register');
    Route::get('/recipes/{id}', 'UserController@getAllRecipes');
    Route::get('currentuser', 'UserController@getCurrentUser');
    Route::get('/{id}', 'UserController@getUserInfo');
});

Route::prefix('/mealprep')->group(function(){
    Route::post('/create', 'MealprepController@createMealprep');
    Route::get('/{id}', 'MealprepController@getMealprep');
    Route::get('/getmealpreps/{id}', 'MealprepController@getMealprepsByUser');
});

