<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\User\ChangePasswordRequest;
use App\Http\Requests\Website\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Mail\VerificationUserMail;
use App\Models\User;
use App\Services\Models\InfluencerModel;
use App\Services\Utils\Imageable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use Imageable;

    public $dataImage = [
        'title' => '',
        'image' => '',
        'dir' => User::DIR
    ];
    public $dataModel = [
        'model' => '',
        'relation' => 'mediaFirst'
    ];

    public function register(Request $request, InfluencerModel $influencerModel)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'phone_number' => ['required'],
            'password' => 'required|string|confirmed|min:6',
            'email' => ['required','email','unique:users'],
            'gender' => ['required','boolean'],
            'referal_token' => ['nullable']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $influencerId = $influencerModel->getInfluencerByToken($request->referal_token);
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'email' => $request->email,
            'gender' => $request->gender,
            'influencer_id' => $influencerId
        ]);

        $token = Str::random(60);
        $user->update(['remember_token' => $token]);

        Mail::to($request->email)->send(new VerificationUserMail($user));

        return response()->json([
            'message' => 'U Register Successfully, please Check Your Email For Verification',
        ], Response::HTTP_CREATED);
    }

    public function verifyAccount($token)
    {
        $user = User::where('remember_token',$token)->whereNULL('email_verified_at')->first();
        if($user){
            $user->update([
                'remember_token' => null,
                'email_verified_at' => Carbon::now()
            ]);
            return response()->json([
                "message" => "Congrats You account is Verified 😎"
            ]);
        }else{
            return response()->json([
                "message" => "Token is Invalid",
            ],Response::HTTP_BAD_REQUEST);
        }
    }

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

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 400);
        }
        if(auth()->user()->email_verified_at){
            return $this->createNewToken($token);
        }else{
            return response()->json([
                'message' => "Maybe Your Account is not verified"
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }


    public function userProfile()
    {
        $user = User::with('mediaFirst')->where('id', Auth::user()->id)->first();

        return response()->json([
            'User' => new UserResource($user)
        ]);
    }




    public function update(UpdateRequest $request)
    {
        $user = User::whereId(auth()->user()->id)->with('mediaFirst')->first();
        $user->update($request->except('image'));
        if($request->file('image')){
            $this->dataImage['title'] =  $user->id;
            $this->dataImage['image'] = $request->image;
            $this->dataModel['model'] = $user;
            $this->handleImageNameAndInsertInDb($this->dataImage, $this->dataModel);
        }
        return response()->json([
            'message' => 'User Updated Data Successfully..',
            'status' => Response::HTTP_ACCEPTED
        ],Response::HTTP_ACCEPTED);
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find(auth()->user()->id);
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
        $user = User::with('mediaFirst')->where('id', Auth::user()->id)->first();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 1000,
            'user' => new UserResource($user)
        ]);
    }


}
