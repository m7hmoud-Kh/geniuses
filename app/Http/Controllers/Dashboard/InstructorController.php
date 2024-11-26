<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Instructor\StoreInstructorRequest;
use App\Http\Requests\Dashboard\Instructor\UpdateInstructorRequest;
use App\Models\Instructor;
use App\Services\Models\InstructorModel;

class InstructorController extends Controller
{
    public $instructorModel;
    public function __construct(InstructorModel $instructorModel)
    {
        $this->instructorModel = $instructorModel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->instructorModel->getAllInstructor();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructorRequest $request)
    {

        return $this->instructorModel->storeInstructor($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        return $this->instructorModel->showInstructor($instructor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        return $this->instructorModel->updateInstructor($request, $instructor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        return $this->instructorModel->destoryInstructor($instructor);
    }
}
