<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    function register(Request $request) {
            try {
                $user = User::updateOrCreate([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => $request->password
                ]);
                if (isset($user->id)) {
                    return [
                        'message' => 'success',
                        'user' => $user,
                        'token'=> $user->createToken('myApp')->plainTextToken
                    ];
                }
                return ['message' => 'failed'];
            } catch(Exception $e) {
                return $e;
            }
    }
}
