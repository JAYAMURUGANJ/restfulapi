<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
//listing all users
    public function getAllUsers()
    {
        return User::all();


    }

    //loged-in user based post with user details
    public function userbasedposts(){
        return User::where('id',auth()->user()->id )
        ->with('posts')->get();
        
    }



    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:5|confirmed',
            'mobile_number' => 'required|digits:10',
            'device_name' => 'required',
            'avatar' => 'required',
        ]);

        //This will check the input starts with 01 and is followed by 9 numbers. By using regex you don't need the numeric or size validation rules.
        if($request->hasfile('avatar')){
            $Random_name =rand();
            $image_file_extension=".png";
            $fileName = $Random_name.$image_file_extension; 
    
            $path =$request->file('avatar')->move(public_path("/uploads/avatars/"),$fileName);
            $photoUrl = url('/uploads/avatars/'.$fileName);
        }

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'mobile_number' => $fields['mobile_number'],
            'device_name' => $fields['device_name'],
            'avatar' => $photoUrl,
        ]);

        //creating token after register
        //$token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'message' => 'New User Created Sccessfully'
        ];

        return response($response, 200);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

          // Check User
          if(!$user) {
            return response([
                'message' => 'Not a valid user'
            ], 401);
        }

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong Password'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Login Success'
        ];

        return response($response, 200);
    }


    public function logout(Request $request) {

        if( $request->user()->currentAccessToken()->delete()) {
            return response([
                'message' => 'Logout Success'
            ], 200);
        } else {
            return response([
                'message' => 'Failed to logout'
            ], 500);
        }

    //     $request->user()->currentAccessToken()->delete();  // delete current access token
    //    // $request->user()->accessToken()->delete;  //delete all access token

    //      return response([
    //         'message' => 'Logout Success'
    //     ], 201);
    }

}
