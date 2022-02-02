<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\FileUpload;
use App\Models\File;
use Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
class ProfileController extends Controller
{
    use   FileUpload;
    public function updateProfile(Request $request)
    {
        
        $user = auth()->guard('api')->user();
        if($user){
            $validation = validator()->make($request->all(), [

                'phone' => 'unique:users,phone,' . $user->id,
                'email' => 'unique:users,email,' . $user->id,
                'birth_date' => 'date|date_format:Y-m-d',
                'image' => 'image|mimes:jpg,png,jpeg',
            ]);

            if ($validation->fails()) {
                $data = $validation->errors();
                return api_response($data, $validation->errors()->first(), 0);
            }
            
            $data = $request->all();
        
            $user->update($data);
            if ($request->image) {
              
                $destinationPath = public_path('upload/users/');
                $file = $request->image;
                $filename = Str::random(5) . '.' . $file->getClientOriginalName();
                $stored = $this->upload($file, null, 'users', $filename);
                $user->image()->save($stored);
                $file->move($destinationPath, $filename);
        } //end if
        
        return api_response(new UserResource($user), __('Profile has been updated successfully'), 1);
    }else{
        return api_response(null, __('Incorrect api token'), 0);
    }
    
    }

     public function dataProfile()
    {
        $user = auth()->guard('api')->user();
        if($user){
          
            return api_response(new UserResource($user), 'success');
        }else{
            return api_response(null, __('Incorrect api token'), 0);
        }
    }
}
