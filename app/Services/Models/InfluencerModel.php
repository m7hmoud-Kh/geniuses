<?php
namespace App\Services\Models;

use App\Http\Resources\InfluencerResource;
use App\Models\Influencer;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InfluencerModel extends Model
{
    use paginatable;

    public function getAllInfluencer()
    {

        $influencers = Influencer::withCount(['users'])
        ->with(['users' => function ($userQuery) {
            $userQuery->with(['subscriptions' =>
                function ($subscriptionQuery) {
                $subscriptionQuery->with([ 'module' => function ($moduleQuery) {
                        // Load price from the module
                        $moduleQuery->select('id', 'price');
                    },
                    'category' => function ($categoryQuery) {
                        // Load price from the category
                        $categoryQuery->select('id', 'price');
                    },
                ]);
            }]);
        }])
        ->latest()
        ->paginate();

    // Calculate total price for each influencer
    $influencers->getCollection()->transform(function ($influencer) {
        $influencer->total_price = $influencer->users->reduce(function ($carry, $user) {
            return $carry + $user->subscriptions->reduce(function ($subCarry, $subscription) {
                $categoryPrice = $subscription->category->price ?? 0;
                $modulePrice = $subscription->module->price ?? 0;
                return $subCarry + $categoryPrice + $modulePrice;
            }, 0);
        }, 0);

        return $influencer;
    });


        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $influencers,
        ]);
    }


    public function getInfluencerByToken($token)
    {
        $influencer = Influencer::where('referal_token', $token)->Status()->first();
        return $influencer ? $influencer->id : null ;
    }

    public function storeInfluencer(Request $request)
    {
        $influencer = Influencer::create($request->validated());
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new InfluencerResource($influencer)
        ],Response::HTTP_CREATED);
    }

    public function showInfluencer(Influencer $influencer)
    {
        return response()->json([
            'data' => new InfluencerResource($influencer)
        ]);
    }

    public function updateInfluencer(Request $request,Influencer $influencer)
    {
        $influencer->update($request->validated());
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new InfluencerResource($influencer)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryInfluencer($influencer)
    {
        $influencer->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
