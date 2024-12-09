<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function getPosts(){
        return response(PostModel::orderBy('created_at', 'DESC')->get());
    }

    public function upload(Request $request){
        $ip_address = base64_decode($request->get('ip_address'));
        // Validate the file input
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,JPEG,PNG|max:10240', // Adjust rules as needed
        ]);
        $caption = $request->caption;
        // Get the uploaded file
        $file = $request->file('file');

        // Define the path to the public folder
        $destinationPath = public_path('uploads');

        // Create the folder if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Generate a unique file name
        $file_name = time() . '_' . $file->getClientOriginalName();
        // Move the file to the public/uploads folder
        $file->move($destinationPath, $file_name);
        
        PostModel::create([
            'ip_address' => $ip_address,
            'caption' => $caption,
            'image_name' => $file_name
        ]);
        
        return response()->json([
            'message' => 'File uploaded successfully',
            'file_name' => $file_name,
            'file_path' => url('uploads/' . $file_name),
        ]);
    }
}
