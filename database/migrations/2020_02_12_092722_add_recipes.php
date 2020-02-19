<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('photo_path');
            $table->string('category_time');
            $table->longText('description');
            $table->boolean('wheat_allergy');
            $table->boolean('milk_allergy');
            $table->text('allergies_list');
            $table->integer('owner_id');	
            $table->integer('votes_id');
            $table->integer('comments_id');	
            $table->timestamps();	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            //
        });
    }
}
