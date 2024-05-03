<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class FooterComponent extends Component
{
    public $animals;
    public $categories;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        if($parentCategory) {
            $this->animals = Category::where('parent_id', $parentCategory->id)->take(6)->get();
            $this->categories = Category::whereNotIn('id', $this->animals->pluck('id'))->take(6)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.footer-component', [
            'animals' => $this->animals,
            'categories' => $this->categories,
        ]);
    }
}
