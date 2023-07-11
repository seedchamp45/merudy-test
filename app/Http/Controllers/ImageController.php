<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class ImageController extends Controller
{
    public function store(Request $request)
    {
      // Validate the uploaded file
      $request->validate([
      'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);

      // Upload the file
      $imageName = time().'.'.$request->image->extension();
      $request->image->storeAs('public/images', $imageName);
      // Insert file data into the database
      $file = new File();
      $file->image_name = $imageName;
      $file->file_path = 'storage/app/public/images/' . $imageName;
      // Add any additional fields you want to save
      $file->save();

      // Redirect back with success message
      return back()->with('success', 'File uploaded successfully.')->with('image', $imageName);
    }

    public function showUploadForm()
    {
        $files = File::all(); // Replace `YourFileModel` with the actual model class for your files

        return view('upload', compact('files'));
    }

}
