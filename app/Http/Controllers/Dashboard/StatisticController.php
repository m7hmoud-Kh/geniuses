<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Models\StatisticModel;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public $statisticModel;

    public function __construct(StatisticModel $statisticModel)
    {
        $this->statisticModel = $statisticModel;
    }

    public function getCurrentEarningMonth()
    {
        return $this->statisticModel->getCurrentEarningMonth();
    }

    public function getYearlyEarning()
    {
        return $this->statisticModel->getYearlyEarning();
    }

}
