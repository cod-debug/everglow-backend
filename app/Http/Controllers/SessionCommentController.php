<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionCommentModel;

class SessionCommentController extends Controller
{
    //
    public function saveComment(Request $request){
        SessionCommentModel::create($request->all());
        
        return response()->json([
            'message' => 'Successfully posted comment.',
        ]);
    }
    
    public function getComment(Request $request){
        $session_type = $request->get('session_type');
        
        $comments = SessionCommentModel::get('session_type', $session_type);

        return response()->json($comments);
    }
}
