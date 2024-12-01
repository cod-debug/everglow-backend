<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function getPublicIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Check if IP is from shared internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check if IP is passed from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Use remote IP address
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getPosts(){
        return response(PostModel::orderBy('created_at', 'DESC')->get());
    }

    public function upload(Request $request){
        // Validate the file input
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,JPEG,PNG|max:2048', // Adjust rules as needed
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
            'ip_address' => $this->getPublicIpAddress(),
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
