<?php

namespace App\Http\Controllers;

use App\Models\MultipleImages;
use Illuminate\Http\Request;

class FirstTaskController extends Controller
{
    public function multipleImageUpload(Request $request){
        //validating the inserted data
        $request->validate([
            'images'=>'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // dd($request->all());
        //checking if user has data
        if($request->hasFile('images')){
            $images = $request->file('images');
            foreach ($images as $image) {
                //get original extension
                $extension = $image->getClientOriginalExtension();
                //making a file name
                $fileName = 'Images-' . md5(uniqid()) . '.'. $extension;
                //saving to project
                $image->move(public_path('assets/uploads'), $fileName);
                //insert into database
                $saveToDb = MultipleImages::create([
                    'images'=> $fileName,
                ]);
            }
            //checking if saved or not
            if ($saveToDb) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Inserted Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed TO insert Data',
                ]);
            }
        }
    }
}
