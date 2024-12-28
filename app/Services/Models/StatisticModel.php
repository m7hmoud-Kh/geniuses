<?php

namespace App\Services\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class StatisticModel extends Model
{
    public function getCurrentEarningMonth()
    {
        $currentMonthEarnings = Subscription::whereMonth('created_at', '=', date('m'))
        ->whereYear('created_at', '=', date('Y'))
        ->with(['module', 'category'])
        ->get()
        ->reduce(function ($sum, $subscription) {
            $modulePrice = $subscription->module->price ?? 0;
            $categoryPrice = $subscription->category->price ?? 0;
            return $sum + $modulePrice + $categoryPrice;
        }, 0);

        return response()->json([
            'data' => [
                'month' => date('M'),
                'total' => round($currentMonthEarnings, 2)
            ]
        ]);
    }

    public function getYearlyEarning()
    {
        $earningsByMonthThisYear = $this->getEarnByYear(date('Y'));
        $earningsByMonthPreviousYear = $this->getEarnByYear(date('Y') - 1);

        $currentYear = $this->getPercentageByMonthInYear($earningsByMonthThisYear);
        $previousYear = $this->getPercentageByMonthInYear($earningsByMonthPreviousYear);
        $total = $currentYear['total'] + $previousYear['total'];

        $currentYear['percentage'] = $this->calculatePercentage($currentYear['total'], $total);
        $previousYear['percentage'] = $this->calculatePercentage($previousYear['total'], $total);

        return response()->json([
            'message' => 'Ok',
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'totalEarning' => $total,
        ]);
    }

    private function getEarnByYear($date)
    {
        return Subscription::selectRaw('MONTH(subscriptions.created_at) as month, SUM(IFNULL(modules.price, 0) + IFNULL(categories.price, 0)) as earnings')
            ->whereYear('subscriptions.created_at', '=', $date)
            ->leftJoin('modules', 'subscriptions.module_id', '=', 'modules.id')
            ->leftJoin('categories', 'subscriptions.category_id', '=', 'categories.id')
            ->groupByRaw('MONTH(subscriptions.created_at)')
            ->orderByRaw('MONTH(subscriptions.created_at)')
            ->pluck('earnings', 'month');
    }

    private function getPercentageByMonthInYear($earnYear)
    {
        $monthNumber = [];
        $earning = [];
        $total = 0;

        foreach ($earnYear as $month => $earn) {
            $monthNumber[] = $month;
            $earning[] = round($earn, 2);
            $total += $earn;
        }

        return [
            'monthYear' => $monthNumber,
            'earning' => $earning,
            'total' => round($total, 2),
        ];
    }

    private function calculatePercentage($totalPerYear, $allTotal)
    {

        if ($allTotal == 0) {
            return 0;
        }
        return round(($totalPerYear / $allTotal) * 100, 2);
    }

}
