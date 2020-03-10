<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function addComment(Request $request, $id){
        $rules = [
            'owner_id' => 'required',
            'comment_text' => 'required',
        ];

        return Comment::create([
            'owner_id' => $request['owner_id'],
            'recipe_id' => $id,
            'comment_text' => $request['comment_text'],
        ]);
    }
}
