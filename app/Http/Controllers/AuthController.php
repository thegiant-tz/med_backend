<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use Exception;
use App\Models\Role;
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
                    'password' => $request->password,
                    'role_id' => Role::where('type', $request->role_name)->first()->id
                ]);

                $user = User::with('role')->where('id', $user->id)->first();
                if (isset($user->id)) {
                    $this->createUserRole($request, $user);
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

    private function createUserRole(Request $request, User $user) {
        if ($request->role_name === 'Recruiter') {
            $user->recruiter()->create([
                'recruiter_no' => 'REC' . str_pad($user->id, 5, 0, STR_PAD_LEFT)
            ]);
        } else if ($request->role_name === 'Driver') {
            $user->driver()->create([
                'driver_no' => 'DRV' . str_pad($user->id, 5, 0, STR_PAD_LEFT)
            ]);
        }
    }

    function Login(Request $request)
    {
        try {
            // return route('add.reminder');
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
            $this->goto();
            return $e->getMessage();
        }
    }


    function Logout(Request $request) {
        // auth()->user()->tokens()->delete();
        return response([
            'message' => 'logged out'
        ], 200);
    }

}

