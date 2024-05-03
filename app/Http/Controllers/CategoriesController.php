<?php

namespace App\Http\Controllers;

use App\Filters\HandbookFilter;
use App\Models\Category;
use App\Models\Handbook;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $parentCategory2 = Category::where('slug', 'kategorii')->first();
        $animals = Category::where('parent_id', $parentCategory->id)->get();
        $categories = Category::where('parent_id', $parentCategory2->id)->get();
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');

        $city = City::where('slug', $selectedCitySlug)->first();

        if (!$city) {
            // Создать новый город только, если он не найден
            $city = new City(['slug' => $selectedCitySlug]);
            $city->save();
        }
        
        $query = Handbook::query()
            ->whereHas('handbooksCategories', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            })
            ->where(function ($q) use ($city) {
                $q->where('address', 'like', '%' . $city->name . '%');
            });
        
        $handbooks = $query->get();
        
        $handbookFilter = new HandbookFilter($request);
        $handbooks = $handbookFilter->apply($query)->paginate(10);
        
        return view('categories.show', ['category' => $category, 'handbooks' => $handbooks, 'city' => $city, 'animals' => $animals, 'categories' => $categories]);
        
    }

    /**
     * Get a list of categories for the API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiList()
    {
        return response()->json(Category::all());
    }

    /**
     * Get a single category details for the API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    public function sortByPrice($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $parentCategory2 = Category::where('slug', 'kategorii')->first();
        $animals = Category::where('parent_id', $parentCategory->id)->get();
        $categories = Category::where('parent_id', $parentCategory2->id)->get();
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');
        
        $city = City::where('slug', $selectedCitySlug)->first();

        if (!$city) {
            $city = new City(['slug' => $selectedCitySlug]);
            $city->save();
        }

        $query = Handbook::query()
            ->whereHas('handbooksCategories', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            })
            ->where(function ($q) use ($city) {
                $q->where('address', 'like', '%' . $city->name . '%');
            })
            ->orderByRaw('CAST(price AS DECIMAL) DESC');
    
        $handbookFilter = new HandbookFilter($request);
        $handbooks = $handbookFilter->apply($query)->paginate(10);

        return view('categories.show', ['category' => $category, 'handbooks' => $handbooks, 'city' => $city, 'animals' => $animals, 'categories' => $categories]);
    }

    public function sortByDistance($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $parentCategory2 = Category::where('slug', 'kategorii')->first();
        $animals = Category::where('parent_id', $parentCategory->id)->get();
        $categories = Category::where('parent_id', $parentCategory2->id)->get();
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');

        $city = City::where('slug', $selectedCitySlug)->first();

        if (!$city) {
            $city = new City(['slug' => $selectedCitySlug]);
            $city->save();
        }

        $userLatitude = $request->input('latitude');
        $userLongitude = $request->input('longitude');
    
        $query = Handbook::query()
        ->select('*')
        ->selectRaw('(6371000 * acos(cos(radians(?)) * cos(radians(coord_x)) * cos(radians(coord_y) - radians(?)) + sin(radians(?)) * sin(radians(coord_x)))) AS distance', [$userLongitude, $userLatitude, $userLongitude])
        ->whereHas('handbooksCategories', function ($q) use ($category) {
            $q->where('category_id', $category->id);
        })
        ->where(function ($q) use ($city) {
            $q->where('address', 'like', '%' . $city->name . '%');
        })
        ->orderBy('distance');
    
        $handbookFilter = new HandbookFilter($request);
        $handbooks = $handbookFilter->apply($query)->paginate(10);
        $handbooks->appends(['latitude' => $userLatitude, 'longitude' => $userLongitude]);
    
        return view('categories.show', ['category' => $category, 'handbooks' => $handbooks, 'city' => $city, 'animals' => $animals, 'categories' => $categories]);
    }

    public function sortByRating($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $parentCategory2 = Category::where('slug', 'kategorii')->first();
        $animals = Category::where('parent_id', $parentCategory->id)->get();
        $categories = Category::where('parent_id', $parentCategory2->id)->get();
        $selectedCitySlug = request()->cookie('selected_city', 'moskva');
        
        $city = City::where('slug', $selectedCitySlug)->first();
    
        if (!$city) {
            $city = new City(['slug' => $selectedCitySlug]);
            $city->save();
        }
    
        $query = Handbook::query()
            ->whereHas('handbooksCategories', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            })
            ->where(function ($q) use ($city) {
                $q->where('address', 'like', '%' . $city->name . '%');
            })->orderByDesc(function ($query) {
                $query->selectRaw('AVG(rating)')
                  ->from('reviews')
                  ->whereColumn('handbooks.id', 'reviews.reviewable_id');
        });
        
        $handbookFilter = new HandbookFilter($request);
        $handbooks = $handbookFilter->apply($query)->paginate(10);
    
        return view('categories.show', ['category' => $category, 'handbooks' => $handbooks, 'city' => $city, 'animals' => $animals, 'categories' => $categories]);
    }    
}
