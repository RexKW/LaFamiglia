<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){
        $request->validate([
            "username" => "required|string",
            "password" => "required|string"
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return back()->with('error', 'Invalid username or password.');

        // $user = User::where("username", $request->username)->first();
        // if (!$user) {


        //     return back()->with('error', 'User not found.');
        // }

        // $inputPassword = trim($request->password);

        // if (!Hash::check($inputPassword, $user->password)) {
        //     return back()->with('error', 'Invalid password.');
        // }
        // session([
        //     'user_id' => $user->id,
        //     'role' => $user->role,
        //     'is_logged_in' => true,
        // ]);

        // return redirect('/home');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request){
        $request->validate([
            "username" => "required|string|unique:users,username",
            "email" => "required|email|unique:users,email",
            "confirm_password" => "required|string|same:password",
            "password" => "required|string"
        ]);

        $inputPassword = trim($request->password);
        $confirmPassword = trim($request->confirm_password);


        if ($inputPassword !== $confirmPassword) {
            return back()->with('error', 'Passwords do not match.');
        }

        $inputPassword = bcrypt($inputPassword);

        $user = User::create([
            "username" => $request->username,
            "email" => $request->email,
            "password" => $inputPassword,
            "role" => "user"
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return redirect('/home');

    }
}
