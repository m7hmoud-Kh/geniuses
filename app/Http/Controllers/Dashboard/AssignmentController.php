<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        return $this->assignmentModel->showAllAssginmentInModule($request);
    }
}
