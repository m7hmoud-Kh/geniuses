<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordReset\sendEmailLinkRequest;
use App\Mail\ResetPasswordMail;
use App\Models\Admin;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    //
    public function sendEmailLink(sendEmailLinkRequest $request)
    {
        $emailFound = User::whereEmail($request->email)->first();
        if($emailFound){
            //get old token if found
            $oldToken = PasswordReset::whereEmail($request->email)->first();
            if($oldToken){
                $token = $oldToken->token;
            }else{
                $token = Str::random(40);
                PasswordReset::create([
                    'email' => $request->email,
                    'token' => $token,
                ]);
            }
            //send Mail
            Mail::to($request->email)->send(new ResetPasswordMail([
                'email' => $request->email,
                'token' => $token,
            ]));
            return response()->json([
                'message' => 'Mail was sent, please Check Your Inbox'
            ]);
        }

        return response()->json([
            'message' => "Email Not Found"
        ],Response::HTTP_NOT_FOUND);
    }

    public function resetPassword(resetPasswordRequest $request)
    {
        $passwordReset = PasswordReset::where('token',$request->token)->first();
        if($passwordReset){
            $message = $this->checkIfUserOrAdminAndResetPassword($passwordReset,$request);
            return response()->json([
                'message' => $message
            ]);
        }
    }

    private function checkIfUserOrAdminAndSendEmail($request)
    {
        if($request->isAdmin){
            $emailFound = Admin::whereEmail($request->email)->first();
        }else{
            $emailFound = User::whereEmail($request->email)->first();
        }

        if($emailFound){
            //get old token if found
            $oldToken = PasswordReset::whereEmail($request->email)->first();
            if($oldToken){
                $token = $oldToken->token;
            }else{
                $token = Str::random(40);
                PasswordReset::create([
                    'email' => $request->email,
                    'token' => $token,
                ]);
            }
            //send Mail
            Mail::to($request->email)->send(new ResetPasswordMail([
                'email' => $request->email,
                'token' => $token,
                'isAdmin' => $request->isAdmin
            ]));
            return 'Mail was sent, please Check Your Inbox';
        }

    }


    private function checkIfUserOrAdminAndResetPassword($passwordReset,$request)
    {
        if($request->isAdmin){
            $emailFound = Admin::where('email',$passwordReset->email)->first();
        }else{
            $emailFound = User::whereEmail($passwordReset->email)->first();
        }

        if($emailFound){
                $emailFound->update([
                    'password' => $request->password,
                ]);
                //delete row reset Password
                $passwordReset->delete();
                return 'Password Updated Successfully';
        }else{
            return response()->json([
                'message' => 'Data invalid'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
