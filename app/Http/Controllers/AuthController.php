<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


// HomeWork 
// 1. Create a method to update the user with profile image 
// 2. Create a method to delete the user 


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $input = $request->all();
        // upload image to the server 
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $name = time() . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $input['profile_image']  = $name;
        }
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('facebook-clone-app')->plainTextToken;
            return response()->json([
                'message' => 'User logged in successfully',
                'user' => Auth::user(),
                'token' => $token
            ], 200);
        } else {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
    }

    /// update user and profile picture 
    public function update(Request $request)
    {
        $user = Auth::user(); // get current user logged in
        $data = $request->all();
        // upload image to the server 
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $name = time() . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $data['profile_image']  = $name;

            $oldImage =   $user->profile_image;
            if ($oldImage) {
                if (file_exists(public_path('images/' . $oldImage))) {
                    unlink(public_path('images/' . $oldImage));
                }
            }
        }
        $user->update($data);
        return response()->json(['message' => 'User updated successfully',], 200);
    }
    public function destroy()
    {
        $user = Auth::user();
        if ($user != null) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function me()
    {
        return response()->json(['user' => Auth::user()], 200);
    }
}
