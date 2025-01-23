<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\ChangePasswordRequest;
use App\Http\Requests\Dashboard\Admin\UpdateRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //check if verify first then login as user
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        if (!$token = auth('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 400);
        }
        if(auth('admin')->user()->email_verified_at){
            return $this->createNewToken($token);
        }else{
            return response()->json([
                'message' => "Maybe Your Account is not verified"
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout()
    {
        auth('admin')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }


    public function userProfile()
    {
        return response()->json([
            'User' => new AdminResource(auth('admin')->user())
        ]);
    }




    public function update(UpdateRequest $request)
    {
        $user = Admin::whereId(auth('admin')->user()->id)->first();
        $user->update($request->validated());
        return response()->json([
            'message' => 'User Updated Data Successfully..',
            'status' => Response::HTTP_ACCEPTED
        ],Response::HTTP_ACCEPTED);
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Admin::find(auth('admin')->user()->id);
        $user->update([
            'password' => $request->password,
        ]);
        return response()->json([
            'message' => 'Password Change Successfully',
            'status' => Response::HTTP_OK
        ]);
    }



    protected function createNewToken($token)
    {
        $user = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 1000 * 100,
            'user' => new AdminResource($user)
        ]);
    }
}
