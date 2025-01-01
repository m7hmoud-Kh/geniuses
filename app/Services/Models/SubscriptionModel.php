<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Module;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionModel extends Model
{

    public function storeSubscription(Request $request)
    {
        $allow_inDays = $this->getallowInDays($request);
        return Subscription::create([
            'start_date' => now(),
            'end_date' => now()->addDays($allow_inDays),
            'user_id' => Auth::user()->id,
            'module_id' => $request->module_id ?? null,
            'category_id' => $request->category_id ?? null
        ]);
    }

    private function getallowInDays(Request $request)
    {
        if(isset($request->category_id)){
            $allow_inDays = Category::whereId($request->category_id)->first()->allow_in_days;
        }else {
            $allow_inDays = Module::whereId($request->module_id)->first()->allow_in_days;
        }
        return $allow_inDays;
    }

    public function checkPaidForCategoryOrModule($request)
    {
        if($request->category_id){
            return Category::find($request->category_id);
        }else{
            return Module::find($request->module_id);
        }
    }

    public function subscribeByAdmin(Request $request)
    {
        $allow_inDays = $this->getallowInDays($request);
        return Subscription::create([
            'start_date' => now(),
            'end_date' => now()->addDays($allow_inDays),
            'user_id' => $request->user_id,
            'module_id' => $request->module_id ?? null,
            'category_id' => $request->category_id ?? null
        ]);
    }
}
