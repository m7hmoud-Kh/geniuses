<?php

namespace App\Services\Models;

use App\Models\User;
use App\Services\Utils\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;

class UserModel extends Model
{
    use Paginatable;


    public function getAllUser()
    {
        $users = User::with(['feedbacks' => function($q){
            return $q->with(['poll','module'])->latest();
        },'subscriptions' => function($q){
            return $q->with(['category','module'])->latest();
        }])->paginate();

        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => UserResource::collection($users),
            'meta' => $this->getPaginatable($users)
        ]);

    }

    public function getAllUsersInSelections()
    {
        $users = User::whereNotNull('email_verified_at')->get(['id','email']);
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $users
        ]);

    }
}
