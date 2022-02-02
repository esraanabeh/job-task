<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Traits\FileUpload;
use App\Models\File;
use App\Http\Resources\UserAuthResource;
class AuthController extends Controller
{
    use   FileUpload;
    public function login(Request $request){
        $this->validate($request , [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = auth()->attempt($request->only(['email' , 'password'])) ||
        auth()->attempt(['phone' => $request->email , 'password' => $request->password]);
        if($user){
            $user = auth()->user();
            return api_response(new UserAuthResource($user));
        }
        return api_response(null , __('Invalid credentials') , 0);
    }

    public function signup(Request $request){
        $this->validate($request , [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:7|max:15',
            'image' => 'image|mimes:jpg,png,jpeg',

        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['type'] = 'user';
        $user = User::create($data);
        if ($request->image) {
                    $destinationPath = public_path('upload/users/');
                    $file = $request->image;
                    $filename = Str::random(5) . '.' . $file->getClientOriginalName();
                    $stored = $this->upload($file, null, 'users', $filename);
                    $user->image()->save($stored);
                    $file->move($destinationPath, $filename);
          } //end if
        if(!$user){
            return api_response(null , __('Unauthorised ...'));
        }

        $message = __('register success');
        return api_response( $user ? new UserAuthResource($user) : [] , $message);
    }
}
