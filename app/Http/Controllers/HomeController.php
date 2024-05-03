<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Handbook;
use App\Models\Review;
use App\Models\City;
use App\Models\SearchTag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $handbooks = Handbook::take(10)->get();
        $categories = Category::all();
        $reviews = Review::published()->take(6)->get();
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');
        $tags = SearchTag::inRandomOrder()->take(6)->get();

        $city = City::where('slug', $selectedCitySlug)->first();

        if (!$city) {
            // Создать новый город только, если он не найден
            $city = new City([
                'name' => $selectedCitySlug,
                'region' => 'moskva',
                'district' => 'moskva',
                'slug' => $selectedCitySlug]);
            $city->save();
        }
        return view('home', compact('handbooks', 'categories', 'reviews', 'city', 'tags'));
    }
}
