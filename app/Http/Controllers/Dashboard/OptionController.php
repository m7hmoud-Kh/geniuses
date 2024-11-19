<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Option\StoreOptionRequest;
use App\Http\Requests\Dashboard\Option\UpdateOptionRequest;
use App\Models\Option;
use App\Services\Models\OptionModel;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $optionModel;

    public function __construct(OptionModel $optionModel)
    {
        $this->optionModel = $optionModel;
    }

    public function index(Request $request)
    {
        return $this->optionModel->getAllOptionByQuestionId($request->questionId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionRequest $request)
    {
        //
        return $this->optionModel->storeOption($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        return $this->optionModel->showOption($option);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionRequest $request, $optionId)
    {
        return $this->optionModel->updateOption($request, $optionId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        return $this->optionModel->destoryOption($option);
    }

    public function destoryAllOptionByQuestionId(Request $request)
    {
        return $this->optionModel->destoryAllOptionByQuestionId($request->questionId);
    }
}
