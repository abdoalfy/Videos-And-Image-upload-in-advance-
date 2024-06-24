<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{

    public function index(){
        $courses=User::all();
        return view('index',compact('courses'));
    }


    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'video' => 'required', // validate video type and size
            'image' => 'required|image|mimes:png,jpg,jpeg|max:10240', // validate image type and size
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $brand_image = $request->file('image');
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
    
            $upload_location = 'images/courses/';
            $image_path = $upload_location . $img_name;
            $brand_image->move(public_path($upload_location), $img_name);
        }
    
        // Handle video upload
        if ($request->hasFile('video')) {
            $brand_video = $request->file('video');
            $name_gen = hexdec(uniqid());
            $video_ext = strtolower($brand_video->getClientOriginalExtension());
            $video_name = $name_gen . '.' . $video_ext;
    
            $upload_location = 'videos/courses/';
            $video_path = $upload_location . $video_name;
            $brand_video->move(public_path($upload_location), $video_name);
        }
    
        // Save to database
        $brand = new User();
        $brand->image = $image_path ?? null; // Use null coalescing operator to avoid undefined variable error
        $brand->video = $video_path ?? null;
        $brand->save();
    
        return redirect()->back()->with('success', 'Course Inserted Successfully');
    }
    
}
