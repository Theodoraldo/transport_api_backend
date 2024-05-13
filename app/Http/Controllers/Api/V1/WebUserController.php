<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebUser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class WebUserController extends Controller
{
    use HasApiTokens;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = null;

        $defaultImagePath = 'default.png';
        $newImagePath = date('Y-m-d_H-i-s') . '.png';

        Storage::disk('images')->copy($defaultImagePath, $newImagePath);

        $user = WebUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $newImagePath,
        ]);

        if ($user) {
            return response([
                'message' => 'New web user created successfully',
                'user_id' => $user->id,
                'name' => $user->name,
            ], Response::HTTP_CREATED);
        } else {
            return response([
                'error' => 'Failed to create new web user',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        try {
            $user = WebUser::where('email', $request->email)->first();

            if (!$user || $user->type !== 'web') {
                return response([
                    'error' => [$request->email . ' you did not register as web user, please use mobile user sign-in']
                ], Response::HTTP_UNAUTHORIZED);
            }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response([
                    'error' => ['Invalid credentials']
                ], Response::HTTP_UNAUTHORIZED);
            }

            $token = $request->user()->createToken('web')->plainTextToken;
            $cookie = cookie('jwt', $token, 60 * 24);

            // Fetch the user data after successful login
            $user = Auth::user();

            // Return the user data along with the token
            return response([
                'message' => $token,
                'user_id' => $user->id,
                'name' => $user->name,
            ])->withCookie($cookie);
        } catch (\Exception $e) {
            return response([
                'error' => ['Request failed: ' . $e->getMessage(), 'code' => $e->getCode()]
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
