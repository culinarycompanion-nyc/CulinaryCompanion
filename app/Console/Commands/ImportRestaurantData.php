<?php

namespace App\Console\Commands;

use App\Models\FoodItem;
use App\Models\Restaurant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportRestaurantData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:restaurants 
        {--restaurants_csv=public/assets/restaurants.csv}
        {--fooditems_csv=public/assets/fooditems.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import restaurant and food item data from CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $restaurantCsv = $this->option('restaurants_csv');
        $foodItemCsv = $this->option('fooditems_csv');


        // Step 1: Import Restaurants
        $this->info('Importing restaurants...');

        if (!file_exists($restaurantCsv)) {
            $this->error("Restaurant CSV not found at: $restaurantCsv");
            return;
        }

        if (($handle = fopen($restaurantCsv, 'r')) !== false) {
            $header = fgetcsv($handle);
            // dd($header);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_map('trim', array_combine($header, $row));

                $placeDetails = [];

                if (!empty($data['PlaceID'])) {
                    $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                        'place_id' => $data['PlaceID'],
                        'fields' => 'formatted_address,current_opening_hours,rating,url,price_level,geometry/location',
                        'key' => env('GOOGLE_API_KEY'),
                    ]);

                    if ($response->successful() && isset($response['result'])) {
                        $result = $response['result'];
                        $placeDetails = [
                            'address' => $result['formatted_address'] ?? $data['AddressLine1'] . ', ' . $data['AddressLine2'] . ', ' . $data['City'] . ', ' . $data['State'] . ', ' . $data['Zipcode'],
                            'operating_hours' => isset($result['current_opening_hours']['weekday_text'])
                                ? implode("\n", $result['current_opening_hours']['weekday_text'])
                                : "Hours of Operation Currently Unavailable",
                            'rating' => $result['rating'] ?? -1.0,
                            'google_maps_link' => $result['url'] ?? $data['GoogleMapsLink'],
                            'latitude' => $result['geometry']['location']['lat'] ?? $data['Latitude'],
                            'longitude' => $result['geometry']['location']['lng'] ?? $data['Longitude'],
                            'price_level' => $result['price_level'] ?? 0,
                        ];
                    } else {
                        // Log or warn if API call fails
                        $this->warn("Failed to fetch Google Places data for PlaceID: {$data['PlaceID']}");
                        $placeDetails = [
                            'address' => $data['AddressLine1'] . ', ' . $data['AddressLine2'] . ', ' . $data['City'] . ', ' . $data['State'] . ', ' . $data['Zipcode'],
                            'operating_hours' => "Hours of Operation Currently Unavailable",
                            'rating' => -1.0,
                            'google_maps_link' => $data['GoogleMapsLink'],
                            'latitude' => $data['Latitude'],
                            'longitude' => $data['Longitude'],
                            'price_level' => 0,
                        ];
                    }
                }

                $this->info('Adding ' . $data['RestaurantName'] . '-' . $data['PlaceID']);


                $restaurant = Restaurant::firstOrCreate([
                    'name' => $data['RestaurantName'],
                    'latitude' => $placeDetails['latitude'],
                    'longitude' => $placeDetails['longitude'],
                ], [
                    'place_id' => $data['PlaceID'],
                    'area' => $data['Area'],
                    'address' => $placeDetails['address'],
                    'state' => $data['State'],
                    'zipcode' => $data['Zipcode'],
                    'operating_hours' => $placeDetails['operating_hours'],
                    'google_maps_link' => $placeDetails['google_maps_link'],
                    'restaurant_website' => $data['RestaurantWebsite'],
                    'instagram_link' => $data['Instagram'],
                    'rating' => $placeDetails['rating'],
                    'price_level' => $placeDetails['price_level'],
                    'image' => $data['Image'],
                    'cuisine' => $data['Cuisine'],
                    'ubereats' => $data['UberEats'],
                    'doordash' => $data['DoorDash'],
                    'grubhub' => $data['GrubHub'],
                    'restaurant_order_link' => $data['RestaurantOrderLink'],
                    'source' => $data['Source'],
                    'last_updated' => $data['LastUpdated'],
                ]);

                // Use composite key for uniqueness
                $key = $restaurant->name . '|' . $restaurant->latitude . '|' . $restaurant->longitude;
                $restaurants[$key] = $restaurant;
            }
            fclose($handle);
        }




        // Step 2: Import Food Items
        $this->info('Importing food items...');

        if (!file_exists($foodItemCsv)) {
            $this->error("Food Item CSV not found at: $foodItemCsv");
            return;
        }

        if (($handle = fopen(base_path($foodItemCsv), 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_map('trim', array_combine($header, $row));

                $foodItem = FoodItem::firstOrCreate([
                    'name' => $data['FoodItem'],
                    'menu_type_idx' => $data['MenuTypeIndex'],
                    'menu_type' => $data['MenuType'],
                    'dish_type_idx' => $data['DishTypeIndex'],
                    'dish_type' => $data['DishType'],
                    'add_on' => $data['AddOn'],
                    'description' => $data['Description'],
                    'dairy' => strtoupper($data['Dairy']) !== 'N',
                    'eggs' => strtoupper($data['Eggs']) !== 'N',
                    'shellfish' => strtoupper($data['ShellFish']) !== 'N',
                    'fish' => strtoupper($data['Fish']) !== 'N',
                    'tree_nuts' => strtoupper($data['TreeNuts']) !== 'N',
                    'peanuts' => strtoupper($data['Peanuts']) !== 'N',
                    'wheat' => strtoupper($data['Wheat']) !== 'N',
                    'soybeans' => strtoupper($data['Soybeans']) !== 'N',
                    'sesame' => strtoupper($data['Sesame']) !== 'N',
                    'vegan' => strtoupper($data['Vegan']) === 'Y',
                    'vegetarian' => strtoupper($data['Vegetarian']) === 'Y',
                    'glutenfree' => strtoupper($data['GlutenFree']) === 'Y',
                    'pescatarian' => strtoupper($data['Pescatarian']) === 'Y',
                ]);

                $matched = false;
                foreach ($restaurants as $restaurant) {
                    if ($restaurant->name === $data['RestaurantName']) {
                        $restaurant->foodItems()->syncWithoutDetaching([$foodItem->id]);
                        $matched = true;
                    }
                }

                if (!$matched) {
                    $this->warn("No restaurant matched for '{$data['RestaurantName']}'. Skipping food item.");
                }
            }
            fclose($handle);
        }


        $this->info('Import completed!');


    }
}





/*


<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Restaurant;
use App\Models\FoodItem;
use Illuminate\Support\Str;

class ImportRestaurantData extends Command
{
    protected $signature = 'import:restaurants 
        {--restaurants_csv=storage/app/restaurants.csv}
        {--fooditems_csv=storage/app/fooditems.csv}';

    protected $description = 'Import restaurant and food item data from CSV files';

    public function handle()
    {
        $restaurantCsv = base_path($this->option('restaurants_csv'));
        $foodItemCsv = base_path($this->option('fooditems_csv'));

        $restaurants = [];

        // Step 1: Import Restaurants
        $this->info('Importing restaurants...');
        if (!file_exists($restaurantCsv)) {
            $this->error("Restaurant CSV not found at: $restaurantCsv");
            return;
        }

        if (($handle = fopen($restaurantCsv, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                $restaurant = Restaurant::firstOrCreate([
                    'name' => $data['RestaurantName'],
                    'latitude' => $data['Latitude'],
                    'longitude' => $data['Longitude'],
                ], [
                    'area' => $data['Area'],
                    'address' => $data['Address'],
                    'operating_hours' => $data['OperatingHours'],
                    'zipcode' => $data['ZipCode'],
                    'google_maps_link' => $data['GoogleMapsLink'],
                    'restaurant_website' => $data['RestaurantWebsite'],
                    'instagram_link' => $data['InstagramLink'],
                    'ratings' => $data['Ratings'],
                    'image' => $data['Image'],
                    'cuisine' => $data['Cuisine'],
                    'ubereats' => $data['UberEats'],
                    'doordash' => $data['DoorDash'],
                    'grubhub' => $data['GrubHub'],
                    'restaurant_order_link' => $data['RestaurantOrderLink'],
                ]);

                // Use composite key for uniqueness
                $key = $restaurant->name . '|' . $restaurant->latitude . '|' . $restaurant->longitude;
                $restaurants[$key] = $restaurant;
            }
            fclose($handle);
        }

        // Step 2: Import Food Items
        $this->info('Importing food items...');
        if (!file_exists($foodItemCsv)) {
            $this->error("Food item CSV not found at: $foodItemCsv");
            return;
        }

        if (($handle = fopen($foodItemCsv, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                // Create or find the food item
                $foodItem = FoodItem::firstOrCreate([
                    'name' => $data['FoodItemName'],
                    'menu_type' => $data['MenuType'],
                    'dish_type' => $data['DishType'],
                    'add_on' => $data['AddOn'],
                    'description' => $data['Description'],
                    'vegetarian' => filter_var($data['Vegetarian'], FILTER_VALIDATE_BOOLEAN),
                    'vegan' => filter_var($data['Vegan'], FILTER_VALIDATE_BOOLEAN),
                    'glutenfree' => filter_var($data['Glutenfree'], FILTER_VALIDATE_BOOLEAN),
                    'dairyfree' => filter_var($data['Dairyfree'], FILTER_VALIDATE_BOOLEAN),
                    'nutfree' => filter_var($data['nutfree'], FILTER_VALIDATE_BOOLEAN),
                ]);

                // Associate with all restaurants matching the name
                $matched = false;
                foreach ($restaurants as $restaurant) {
                    if ($restaurant->name === $data['RestaurantName']) {
                        $restaurant->foodItems()->syncWithoutDetaching([$foodItem->id]);
                        $matched = true;
                    }
                }

                if (!$matched) {
                    $this->warn("No restaurant matched for '{$data['RestaurantName']}'. Skipping food item.");
                }
            }
            fclose($handle);
        }

        $this->info('✅ Import completed successfully!');
    }
}



*/
