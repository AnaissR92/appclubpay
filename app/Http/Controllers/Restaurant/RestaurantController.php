<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\Food;
use App\Models\Language;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\FoodCategory;
use App\Models\RestaurantSettings;
use Illuminate\Http\Request;
use App\Models\RestaurantType;
use App\Models\RestaurantUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\Restaurant\RestaurantRequest;
use App\Repositories\Restaurant\RestaurantRepository;
use App\Repositories\Restaurant\FoodCategoryRepository;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show restaurants')->only('index', 'show');
        $this->middleware('permission:add restaurants')->only('create', 'store');
        $this->middleware('permission:edit restaurants')->only('edit', 'update');
        $this->middleware('permission:delete restaurants')->only('destroy');
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();

        $params = $request->only('par_page', 'sort', 'direction', 'filter');

        $par_page = 10;
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }
        $params['par_page'] = $par_page;

        if ($user->user_type == User::USER_TYPE_STAFF) {

            $assigned_restaurant = RestaurantUser::where('user_id', $user->id)->pluck('restaurant_id')->toArray();
            $params['assigned_restaurant'] = $assigned_restaurant;
            $params['user_id'] = $user->created_by;

        } elseif ($user->user_type == User::USER_TYPE_VENDOR) {
            $params['user_id'] = $user->id;
        }

        $restaurants = (new RestaurantRepository())->getUserRestaurants($params);
        return view('restaurant.restaurants.index', ["restaurants" => $restaurants]);
    }

    protected function checkPlan($user)
    {

        $userPlan = isset($user->current_plans[0]) ? $user->current_plans[0] : '';
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner = User::find($user->created_by);
            $userPlan = isset($owner->current_plans[0]) ? $owner->current_plans[0] : '';
        }


        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
        $userRestaurants = Restaurant::where('user_id', $vendor_id)->count();

        if ($user->user_type != User::USER_TYPE_ADMIN && $userPlan && $user->free_forever != true) {

            if ((!$userPlan || $userRestaurants >= $userPlan->restaurant_limit) && $userPlan->restaurant_unlimited != 'yes') {
                return false;
            }
        } else if ($user->user_type != User::USER_TYPE_ADMIN && !$userPlan) {
            return false;
        }
        return true;
    }

    public function create()
    {
        $user = auth()->user();

        $languages = Language::all();
        $restaurantTypes = RestaurantType::select('id', 'type', 'lang_restaurant_type')->orderBy('type', 'asc')->get();
        if ($this->checkPlan($user) == false) {
            if ($user->user_type == User::USER_TYPE_STAFF) {
                return redirect()->route('home')->with(['Error' => __('system.plans.restaurant_extends')]);
            }
            return redirect()->route('restaurant.vendor.plan')->with(['Error' => __('system.plans.restaurant_extends')]);
        }

        if ($user->user_type == User::USER_TYPE_ADMIN) {
            $vendors = User::where('user_type', User::USER_TYPE_VENDOR)->where('status', 1)->orderBy('first_name', 'asc')->get();
        } else {
            $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
            $vendors = User::find($vendor_id);
        }

        return view('restaurant.restaurants.create', compact('vendors', 'languages', 'restaurantTypes'));
    }

    public function store(RestaurantRequest $request)
    {
        $user = auth()->user();
        if ($this->checkPlan($user) == false) {
            if ($user->user_type == User::USER_TYPE_STAFF) {
                return redirect()->route('home')->with(['Error' => __('system.plans.restaurant_extends')]);
            }
            return redirect()->route('restaurant.vendor.plan')->with(['Error' => __('system.plans.restaurant_extends')]);
        }

        $user = auth()->user();
        $data = $request->only('name', 'user_id', 'slug', 'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'linkedin_url', 'tiktok_url', 'type', 'contact_email', 'phone_number', 'language', 'city', 'state', 'country', 'zip', 'address', 'logo', 'dark_logo', 'cover_image', 'clone_data_into', 'theme');


        DB::beginTransaction();
        $newRestaurant = Restaurant::create($data);
        $restaurantTypeId = RestaurantType::where('type', $request->type)->value('id');
        $newRestaurant->restaurant_type_id = $restaurantTypeId;
        $newRestaurant->save();

        $restaurantSetting = ['user_id' => $newRestaurant->user_id, 'allow_language_change' => $request->allow_language_change, 'allow_dark_light_mode_change' => $request->allow_dark_light_mode_change, 'allow_direction' => $request->allow_direction, 'allow_show_allergies' => $request->allow_show_allergies, 'allow_show_calories' => $request->allow_show_calories, 'allow_show_preparation_time' => $request->allow_show_preparation_time, 'allow_show_food_details_popup' => $request->allow_show_food_details_popup, 'allow_show_banner' => $request->allow_show_banner, 'call_the_waiter' => $request->call_the_waiter, 'allow_show_restaurant_name_address' => $request->allow_show_restaurant_name_address,];

        //Save Restaurant settings.
        RestaurantSettings::updateOrCreate(['user_id' => $newRestaurant->user_id, 'restaurant_id' => $newRestaurant->id,], $restaurantSetting);

        if ($user->user_type == User::USER_TYPE_STAFF) {
            RestaurantUser::create(['restaurant_id' => $newRestaurant->id, 'user_id' => $user->id, 'role' => User::USER_TYPE_STAFF,]);
        }

        $inserts = [];
        $insertedFood = [];
        if (isset($data['clone_data_into'])) {

            $params['restaurant_id'] = $data['clone_data_into'];
            $foodCategories = (new FoodCategoryRepository)->getRestaurantFoodCategories($params);
            $foodCategories->load('foods');

            foreach ($foodCategories as $category) {

                $newCategory = (new FoodCategory)->fill($category->toarray());
                $newCategory->restaurant_id = $newRestaurant->id;
                $newCategory->save();
                $cat_id = $newCategory->id;

                foreach ($category->foods as $food) {
                    if (!in_array($food->name, $insertedFood)) {
                        $insertedFood[] = $food->name;
                        $newfood = (new Food())->fill($food->toarray());
                        $newfood->restaurant_id = $newRestaurant->id;
                        $newfood->save();
                    }
                    $inserts[] = ['food_category_id' => $cat_id, 'food_id' => $newfood->id];
                }
            }

            if (count($inserts) > 0) {
                $inserts = array_map("unserialize", array_unique(array_map("serialize", $inserts)));
                $d = DB::table('food_food_category')->insert($inserts);
            }
        }

        $check_user = User::find($newRestaurant->user_id);
        if ($check_user->restaurant_id == null || $check_user->restaurant_id == "") {
            $check_user->restaurant_id = $newRestaurant->id;
            $check_user->save();
        }

        //Assign Vendor To Restro
        RestaurantUser::create(['restaurant_id' => $newRestaurant->id, 'user_id' => $newRestaurant->user_id, 'role' => User::USER_TYPE_VENDOR,]);

        DB::commit();
        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.restaurants.title')]));
        return redirect(route('restaurant.restaurants.index'));
    }

    public function show(Restaurant $restaurant)
    {
        if (($redirect = $this->checkRestaurantIsValidUser($restaurant)) != null) {
            return redirect($redirect);
        }
        $restaurant->load(['created_user', 'users' => function ($q) {
            $q->limit(5);
        }]);
        return view('restaurant.restaurants.view', ['restaurant' => $restaurant]);
    }

    public function edit(Restaurant $restaurant)
    {
        $user = auth()->user();
        $languages = Language::all();
        $restaurantTypes = RestaurantType::select('id', 'type', 'lang_restaurant_type')->orderBy('type', 'asc')->get();
        if (($redirect = $this->checkRestaurantIsValidUser($restaurant)) != null) {
            return redirect($redirect);
        }

        if ($user->user_type == User::USER_TYPE_ADMIN) {
            $vendors = User::where('user_type', User::USER_TYPE_VENDOR)->where('status', 1)->orderBy('first_name', 'asc')->get();
        } else {
            $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
            $vendors = User::find($vendor_id);
        }
        $setting = $restaurant->settings;
        return view('restaurant.restaurants.edit', ['restaurant' => $restaurant,'languages'=>$languages, 'setting' => $setting, 'vendors' => $vendors, 'restaurantTypes' => $restaurantTypes]);
    }

    public function checkRestaurantIsValidUser($restaurant)
    {

        $user = auth()->user();
        if ($user->user_type == User::USER_TYPE_ADMIN) {
            return;
        }
        $restaurant->load(['users' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }]);

        if (count($restaurant->users) == 0) {
            $back = request()->get('back', route('restaurant.restaurants.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.restaurants.title')]));

            return $back;
        }
    }

    public function createQR()
    {
        $users = auth()->user();
        $users->load(['restaurant' => function ($q) {
            $q->select('restaurants.*');
        }]);
        $restaurant = $users->restaurant;

        $file_name=$restaurant->id.'.svg';
        $qr_path=public_path('qrcodes/'.$file_name);
        $download_path=asset('qrcodes/'.$file_name);

        QrCode::size(450)->generate(route('frontend.restaurant', $restaurant->slug), $qr_path);

        return view('restaurant.restaurants.create_qr', ['restaurant' => $restaurant,'download_name'=>$restaurant->slug.'.svg','download_path'=>$download_path]);
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        if (($redirect = $this->checkRestaurantIsValidUser($restaurant)) != null) {
            return redirect($redirect);
        }
        $restaurantTypeId = RestaurantType::where('type', $request->type)->value('id');

        $data = $request->only('name', 'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'linkedin_url', 'tiktok_url', 'slug', 'type', 'contact_email', 'phone_number', 'language', 'city', 'state', 'country', 'zip', 'address', 'logo', 'cover_image', 'dark_logo', 'theme');
        $restaurant->restaurant_type_id = $restaurantTypeId;
        $restaurant->fill($data)->save();


        $restaurantSetting = ['user_id' => $restaurant->user_id, 'allow_language_change' => $request->allow_language_change, 'allow_dark_light_mode_change' => $request->allow_dark_light_mode_change, 'allow_direction' => $request->allow_direction, 'allow_show_allergies' => $request->allow_show_allergies, 'allow_show_calories' => $request->allow_show_calories, 'allow_show_preparation_time' => $request->allow_show_preparation_time, 'allow_show_food_details_popup' => $request->allow_show_food_details_popup, 'allow_show_banner' => $request->allow_show_banner, 'allow_show_restaurant_name_address' => $request->allow_show_restaurant_name_address, 'call_the_waiter' => $request->call_the_waiter,];

        //Save Restaurant settings.
        RestaurantSettings::updateOrCreate(['user_id' => $restaurant->user_id, 'restaurant_id' => $restaurant->id,], $restaurantSetting);

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.restaurants.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('restaurant.restaurants.index'));
    }

    public function defaultRestaurant(Restaurant $restaurant)
    {
        if (($redirect = $this->checkRestaurantIsValidUser($restaurant)) != null) {
            return redirect($redirect);
        }
        $user = request()->user();
        $request = request();
        $user->restaurant_id = $restaurant->id;
        $user->save();
        $request->session()->flash('Success', __('system.messages.change_success_message', ['model' => __('system.restaurants.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('home'));
    }

    public function destroy(Restaurant $restaurant)
    {
        $request = request();
        if (($redirect = $this->checkRestaurantIsValidUser($restaurant)) != null) {
            return redirect($redirect);
        }
        $restaurant->load(['users' => function ($q) use ($restaurant) {
            $q->where('users.restaurant_id', $restaurant->id);
        }]);

        if (count($restaurant->users) > 0) {
            foreach ($restaurant->users as $restoUser) {
                $restoUser->load(['restaurants' => function ($q) use ($restaurant) {
                    $q->wherePivot('restaurant_id', '!=', $restaurant->id);
                }]);
                if (count($restoUser->restaurants) > 0) {
                    $restoUser->restaurant_id = $restoUser->restaurants->first()->id;
                } else {
                    $restoUser->restaurant_id = null;
                }
                $restoUser->save();
            }
        }
        $restaurant->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.restaurants.title')]));

        if ($request->back) {
            return redirect($request->back);
        }

        return redirect(route('restaurant.restaurants.index'));
    }

    public static function getRestaurantsDropdown()
    {
        $restaurants = (new RestaurantRepository())->getAllRestaurantsWithIdAndName();
        return $restaurants;
    }

    public static function getVendors()
    {
        $restaurants = (new RestaurantRepository())->getVendorsList();
        return $restaurants;
    }


    public function genarteQR(Restaurant $restaurant)
    {
        $file_name=$restaurant->id.'.svg';
        $qr_path=public_path('qrcodes/'.$file_name);
        $download_path=asset('qrcodes/'.$file_name);

        QrCode::size(450)->generate(route('frontend.restaurant', $restaurant->slug), $qr_path);
        return view('restaurant.restaurants.create_qr', ['restaurant' => $restaurant,'download_name'=>$restaurant->slug.'.svg','download_path'=>$download_path]);
    }
}
