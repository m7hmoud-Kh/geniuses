<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Assignment\StoreAssginmentRequest;
use App\Services\Models\AssignmentModel;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public $assignmentModel;

    public function __construct(AssignmentModel $assignmentModel)
    {
        $this->assignmentModel = $assignmentModel;
    }

    public function index(Request $request)
    {
        return $this->assignmentModel->index($request);
    }

    public function store(StoreAssginmentRequest $request)
    {
        return $this->assignmentModel->store($request);
    }

    public function destory(Request $request)
    {
        return $this->assignmentModel->destory($request);
    }
}
