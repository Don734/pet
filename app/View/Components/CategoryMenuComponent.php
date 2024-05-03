<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\City;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;

class CategoryMenuComponent extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Category::whereMenuItem(1)->get();
        $this->cities = City::all();
        $this->city = City::whereSlug(Cookie::get('selected_city'))->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.category-menu-component', [
            'categories' => $this->categories,
            'cities' => $this->cities,
            'city' => $this->city
        ]);
    }
}
