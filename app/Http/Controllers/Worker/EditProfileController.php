<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\AppFunction;
use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    //* ##### Username #####
    public function getUsername() {
        $worker = auth()->user();
        return response()->json([
            'success' => true,
            'message' => "Get username",
            'data' => ['username' => $worker->username],
        ]);
    }
    
    public function setUsername(Request $request) {
        $request->validate(['username' => 'required']);
        $worker = Worker::find(auth()->user()->id);
        
        $worker->username = $request->username;
        $worker->save();
        
        return response()->json([
            'success' => true,
            'message' => "successful edit username",
            'data' => [],
        ]);
    }
    
    //* ##### Profile Image #####
    public function getProfileImage() {
        $worker = auth()->user();
        return response()->json([
            'success' => true,
            'message' => "Get profile image",
            'data' => ['username' => $worker->profile_image],
        ]);
    }
    
    public function setProfileImage(Request $request) {
        $request->validate(['profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $worker = Worker::find(auth()->user()->id);
        
        if (isset($worker->profile_image)) {
            Storage::delete($worker->profile_image);
        }

        $profileImagePath ='images/worker/profile';
        $profileImageName = AppFunction::getImageName($request->file('profile_image'));
        $worker->profile_image = $profileImagePath.'/'.$profileImageName;
        $request->file('profile_image')->storeAs($profileImagePath, $profileImageName);
        $worker->save();
        
        return response()->json([
            'success' => true,
            'message' => "successful change profile image",
            'data' => [],
        ]);
    }
    
    //* ##### Backdrop Image #####
    public function getBackdropImage() {
        $worker = auth()->user();
        return response()->json([
            'success' => true,
            'message' => "Get backdrop image",
            'data' => ['username' => $worker->backdrop_image],
        ]);
    }
    
    public function setBackdropImage(Request $request) {
        $request->validate(['backdrop_image' => 'required|image|mimes:jpeg,png,jpg|max:5120']);
        $worker = Worker::find(auth()->user()->id);
        
        if (isset($worker->backdrop_image)) {
            Storage::delete($worker->backdrop_image);
        }

        $backdropImagePath ='images/worker/backdrop';
        $backdropImageName = AppFunction::getImageName($request->file('backdrop_image'));
        $worker->backdrop_image = $backdropImagePath.'/'.$backdropImageName;
        $request->file('backdrop_image')->storeAs($backdropImagePath, $backdropImageName);
        $worker->save();
        
        return response()->json([
            'success' => true,
            'message' => "successful change backdrop image",
            'data' => [],
        ]);
    }
}