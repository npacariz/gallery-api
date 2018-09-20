<?php

namespace App\Http\Controllers;
use App\Http\Requests\CommentRequest;

use Illuminate\Http\Request;
use App\Comment;
class CommentController extends Controller
{
    /**
     * Controller for storing comments
     */
     public function store(CommentRequest $request) {
        return Comment::addComment($request);
     }
     /**
      * Controller for deleting comment
      */
     public function destroy($comment) {
         return Comment::destroy($comment);
     }
}
