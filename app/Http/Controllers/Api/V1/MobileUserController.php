<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileUser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MobileUserController extends Controller
{
    public function signup(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required | email | unique:users',
        //     'password' => 'required | min:6 | confirmed',
        // ]);

        return MobileUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function signin(Request $request)
    {
        $user = MobileUser::where('email', $request->email)->first();

        if (!$user || $user->type !== 'mobile') {
            return response([
                'error' => [$request->email . ' you did not register as mobile user, please use web user sign-in']
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'error' => ['Invalid credentials']
            ], Response::HTTP_UNAUTHORIZED);
        }

        //$token = $user->createToken('mobile')->plainTextToken;
        $token = $request->user()->createToken('mobile')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 day

        return response([
            'message' => $token,
        ])->withCookie($cookie);
    }

    public function signout()
    {
        $cookie = cookie('jwt', '', -1); // delete cookie

        return response([
            'message' => 'success',
        ])->withCookie($cookie);

        return Auth::user();
    }
}
