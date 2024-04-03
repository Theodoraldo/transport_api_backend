<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileUser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class MobileUserController extends Controller
{
    use HasApiTokens;

    public function signup(Request $request)
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

        $defaultImagePath = 'default.png';
        $newImagePath = date('Y-m-d_H-i-s') . '.png';

        Storage::disk('images')->copy($defaultImagePath, $newImagePath);

        MobileUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $newImagePath,
        ]);

        return response([
            'message' => 'New mobile user created successfully',
        ], Response::HTTP_CREATED);
    }

    public function signin(Request $request)
    {
        try {
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

            $token = $request->user()->createToken('mobile')->plainTextToken;
            $cookie = cookie('jwt', $token, 60 * 24);
        } catch (\Exception $e) {
            return response([
                'error' => ['Request failed: ' . $e->getMessage(), 'code' => $e->getCode()]
            ], Response::HTTP_BAD_REQUEST);
        }

        return response([
            'message' => $token,
        ])->withCookie($cookie);
    }

    public function update(Request $request)
    {
        try {
            $user = MobileUser::findOrFail($request->id);

            // $validator = Validator::make($user, [
            //     'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //     'cellphone' => 'required',
            // ]);

            // if ($validator->fails()) {
            //     return response([
            //         'error' => $validator->errors(),
            //     ], Response::HTTP_UNPROCESSABLE_ENTITY);
            // }

            $data = $request->except('image', 'type', 'password', 'email', 'name');
            $user->fill($data);

            if ($request->hasFile('image')) {
                if ($user->image && Storage::disk('images')->exists($user->image)) {
                    Storage::disk('images')->delete($user->image);
                }
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $path = $image->storeAs('/', $imageName, 'images');
                $user->image = $path;
            }
            $user->save();
            return response()->json("User record updated successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function signout()
    {
        $cookie = cookie('jwt', '', -1); // delete cookie

        // auth()->user()->tokens()->delete();

        return response([
            'message' => 'User signed out successfully',
        ])->withCookie($cookie);
    }
}
