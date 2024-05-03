<?php

namespace App\Http\Controllers;

use App\Models\Handbook;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $animals = Category::where('parent_id', $parentCategory->id)->get();

        $city = City::where('slug', $selectedCitySlug)->first();

        if (!$city) {
            // Создать новый город только, если он не найден
            $city = new City(['slug' => $selectedCitySlug]);
            $city->save();
        }
        $query = $request->input('query');
        $handbooks = Handbook::where('title', 'like', "%$query%")->paginate(10);

        $handbooks->appends(['query' => $query]);

        return view('search.results', ['handbooks' => $handbooks, 'query' => $query, 'city' => $city, 'animals' => $animals]);
    }

    public function allServices()
    {
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $animalCategoryIds = Category::where('parent_id', $parentCategory->id)->pluck('id');
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');
        $city = City::where('slug', $selectedCitySlug)->first();
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $animals = Category::where('parent_id', $parentCategory->id)->get();

        if (!$city) {
            $city = new City(['slug' => $selectedCitySlug]);
            $city->save();
        }
        
        $handbooks = Handbook::query()
        ->whereDoesntHave('categories', function ($q) use ($animalCategoryIds) {
            $q->whereIn('category_id', $animalCategoryIds);
        })
        ->whereHas('categories', function ($q) use ($city) {
            $q->where('address', 'like', '%' . $city->name . '%');
        })
        ->paginate(10);
        
        return view('search.results', compact('handbooks', 'city', 'animals'));
    }

    public function searchAutocomplete(Request $request)
    {
        $query = $request->input('query');
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');
        $city = City::where('slug', $selectedCitySlug)->first();
    
        if (!$city) {
            $city = new City(['slug' => $selectedCitySlug]);
            $city->save();
        }
    
        $results = Handbook::where('title', 'like', "%$query%")
            ->whereHas('handbooksCategories', function ($q) use ($city) {
                $q->where('address', 'like', '%' . $city->name . '%');
            })
            ->take(5)
            ->get();
    
        // Загружаем отношение 'categories' для каждого результата
        $results->load('categories');
    
        return view('search.results_autocomplete', compact('results'));
    }    
}
