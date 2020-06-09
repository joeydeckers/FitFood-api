<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\User;

class CommentController extends Controller
{
    public function addComment(Request $request, $id){
        $rules = [
            'owner_id' => 'required',
            'comment_text' => 'required',
        ];

        $user = User::find($request['owner_id']);

        return Comment::create([
            'owner_id' => $user->name,
            'recipe_id' => $id,
            'comment_text' => $request['comment_text'],
        ]);
    }
}
