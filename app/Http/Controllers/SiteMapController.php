<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function show()
    {
        $parentCategory1 = Category::where('slug', 'zivotnye')->first();
        $parentCategory2 = Category::where('slug', 'kategorii')->first();
        $excludeCategories = [$parentCategory1->id, $parentCategory2->id];
        $animals = Category::where('parent_id', $parentCategory1->id)->get();
        $categories = Category::whereNotIn('id', $animals->pluck('id'))
            ->whereNotIn('id', $excludeCategories)
            ->get();
        return view('site_map', compact('categories', 'animals'));        
    }
}

