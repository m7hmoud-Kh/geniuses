<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index()
    {
        return $this->userModel->getAllUser();
    }

    public function getAllUsersInSelections()
    {
        return $this->userModel->getAllUsersInSelections();
    }
}
