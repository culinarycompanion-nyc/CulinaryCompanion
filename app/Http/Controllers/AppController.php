<?php

namespace App\Http\Controllers;

use App\Models\LinkVisit;
use App\Models\OptionSelection;
use App\Models\Restaurant;
use App\Models\RestaurantVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    //

    public function selections()
    {

        $validated = request()->validate([
            'checkboxes' => 'array',
            'checkboxes.*' => 'string',
        ]);

        $selectedOptions = request('checkboxes') ?? [''];

        session(['selectedOptions' => $selectedOptions]);

        $today = Carbon::today();
        $normalizedOptions = collect($selectedOptions)->sort()->values()->all(); // Ensure consistent ordering
        $combinationKey = implode(',', $normalizedOptions);

        OptionSelection::firstOrCreate(
            ['selections' => $combinationKey, 'selection_date' => $today],
            ['selection_count' => 0]
        )->increment('selection_count');

        if (request()->filled('rest')) {
            return redirect('/restaurant/' . request('rest'));
        } else {
            if (request()->filled('areas')) {
                $validated = request()->validate([
                    'areas' => 'array',
                    'areas.*' => 'string',
                ]);

                $selectedAreas = request('areas') ?? [''];
                // dd($selectedAreas);
                session(['selectedAreas' => $selectedAreas]);
            }
            return redirect('/restaurants');
        }
    }


    public function restaurants()
    {
        $selectedOptions = session('selectedOptions', ['']);

        $selectedAreas = [''];

        if (session()->has('selectedAreas') && !empty(session('selectedAreas'))) {
            $selectedAreas = session('selectedAreas');
            session()->forget('selectedAreas');
            // dd($selectedAreas);
        }




        $selectedOptions = session('selectedOptions', ['']);

        $userAllergens = array_intersect($selectedOptions, ['dairy', 'eggs', 'shellfish', 'fish', 'tree_nuts', 'peanuts', 'wheat', 'soybeans', 'sesame']);
        $userDietaryPreferences = array_intersect($selectedOptions, ['vegetarian', 'vegan', 'glutenfree', 'pescatarian']);


        $restaurants = Restaurant::whereHas('foodItems', function ($query) use ($userAllergens, $userDietaryPreferences) {
            foreach ($userAllergens as $allergen) {
                $query->where($allergen, false);
            }

            foreach ($userDietaryPreferences as $diet) {
                $query->where($diet, true);
            }
        })->when($selectedAreas !== [''], function ($query) use ($selectedAreas) {
            $query->whereIn('area', $selectedAreas);
        })->get()->shuffle();


        $areas = Restaurant::select('area')->where('area', '!=', '')->distinct()->orderBy('area', 'asc')->pluck('area');

        // dd($areas);

        // dd(compact('selectedOptions', 'restaurants'));

        return view('restaurants', compact('selectedOptions', 'restaurants', 'userAllergens', 'userDietaryPreferences', 'areas', 'selectedAreas'));
    }


    public function restaurant($id)
    {
        $selectedOptions = session('selectedOptions', ['']);

        $restaurant = Restaurant::with('foodItems')->find($id);

        if (!$restaurant) {
            abort('404');
        }

        $today = Carbon::today();
        RestaurantVisit::firstOrCreate(
            [
                'restaurant_name' => $restaurant->name,
                'restaurant_address' => $restaurant->address,
                'visit_date' => $today,
            ],
            ['visit_count' => 0]
        )->increment('visit_count');

        $userAllergens = array_intersect($selectedOptions, ['dairy', 'eggs', 'shellfish', 'fish', 'tree_nuts', 'peanuts', 'wheat', 'soybeans', 'sesame']);
        $userDietaryPreferences = array_intersect($selectedOptions, ['vegetarian', 'vegan', 'glutenfree', 'pescatarian']);

        $foodItems = $restaurant->foodItems
            ->filter(function ($item) use ($userAllergens, $userDietaryPreferences) {
                // Ensure all allergens are false
                foreach ($userAllergens as $allergen) {
                    if (!empty($item->$allergen)) {
                        return false;
                    }
                }

                // Ensure all dietary preferences are true
                foreach ($userDietaryPreferences as $preference) {
                    if (empty($item->$preference)) {
                        return false;
                    }
                }

                return true;
            })
            ->sortBy(fn($item) => [$item->menu_type_idx, $item->dish_type_idx])
            ->groupBy('menu_type')
            ->map(fn($items) => $items->groupBy('dish_type'));

        // dd($foodItems);



        // dd(compact('selectedOptions', 'restaurants'));

        return view('restaurant', compact('selectedOptions', 'restaurant', 'foodItems'));
    }


    public function redirect($encodedUrl)
    {
        $url = base64_decode($encodedUrl);


        $restaurant = Restaurant::where('ubereats', $url)
            ->orWhere('doordash', $url)
            ->orWhere('grubhub', $url)
            ->orWhere('restaurant_order_link', $url)
            ->first();



        if ($restaurant) {
            $linkType = collect(['ubereats', 'doordash', 'grubhub', 'restaurant_order_link'])
                ->first(fn($type) => $restaurant->$type === $url);

            $today = Carbon::today();

            // Track visit using name and address
            LinkVisit::firstOrCreate(
                [
                    'restaurant_name' => $restaurant->name,
                    'restaurant_address' => $restaurant->address,
                    'link_type' => $linkType,
                    'link' => $url,
                    'visit_date' => $today,
                ],
                ['visit_count' => 0]
            )->increment('visit_count');


            return redirect($url);
        }

        return redirect('/');
    }
}
