<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    function Login(Request $request)
    {
        try {
            
            if (!isset($request->authenticateThrough) || $request->authenticateThrough == 'email') {
                $user = User::with('role')->where('email', $request->email)->first();
            } else if ($request->authenticateThrough == 'phone') {
                $user = User::with('role')->where('phone', $request->phone)->first();
            }
            
            if (!is_null($user)) {
                if (Hash::check($request->password, $user->password)) {
                    return (object) array(
                        'message' => 'authorized',
                        'user' => $user,
                        'token' => $user->createToken('myApp')->plainTextToken
                    );
                } else {

                    $message = 'unauthorized';
                }
            } else {
                $message = 'unauthorized';
            }
            return (object) array(
                'message' => $message
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
