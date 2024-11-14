<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Fqa\StoreFqaRequest;
use App\Http\Requests\Dashboard\Fqa\UpdateFqaRequest;
use App\Models\Fqa;
use App\Services\Models\FqaModel;
use Illuminate\Http\Request;

class FqaController extends Controller
{
    public $fqaModel;
    public function __construct(FqaModel $fqaModel)
    {
        $this->fqaModel = $fqaModel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->fqaModel->getAllFqa();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFqaRequest $request)
    {

        return $this->fqaModel->storeFqa($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fqa $fqa)
    {
        return $this->fqaModel->showFqa($fqa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFqaRequest $request, Fqa $fqa)
    {
        return $this->fqaModel->updateFqa($request, $fqa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fqa $fqa)
    {
        return $this->fqaModel->destoryFqa($fqa);
    }
}
