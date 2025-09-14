<?php

namespace App\Http\Controllers;

use App\Filters\HandbookFilter;
use App\Http\Requests\HandbookRequest;
use App\Models\Category;
use App\Models\Handbook;
use App\Repositories\HandbookRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HandbooksController extends Controller
{
    protected $handbookRepository;
    public function __construct(HandbookRepository $handbookRepository)
    {
        $this->handbookRepository = $handbookRepository;
    }

    public function index(Request $request)
    {
        $query = Handbook::query()->with('category');
        $handbookFilter = new HandbookFilter($request);
        $handbooks = $handbookFilter->apply($query)->paginate(10);
        $categories = Category::get(['id', 'name']);

        return view('handbooks.index', compact('handbooks', 'categories'));
    }

    public function show($id)
    {
        $handbook = Handbook::findOrFail($id);
        $category = Category::find($handbook->category_id);
        return view('handbooks.show', compact('handbook', 'category'));
    }

    public function store(HandbookRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['client_id'] = auth('users')->id();
        $handbook = Handbook::create($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $handbook->addMedia($file)->toMediaCollection('images');
            }
        }

        return redirect()->route('profile')->with('success', 'Справочник успешно создан.');
    }

    /**
     * Get a list of handbooks for the API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiList()
    {
        $handbooks = Handbook::with('category')->get()->map(function ($handbook) {
            return $this->handbookRepository->formatApiData($handbook);
        });

        return response()->json($handbooks);
    }

    /**
     * Get a single handbook details for the API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow($slug)
    {
        $handbook = Handbook::whereSlug($slug)->with('category')->first();

        if (!$handbook) {
            return response()->json(['error' => 'Handbook not found'], 404);
        }

        $handbookData = $this->handbookRepository->formatApiData($handbook);

        return response()->json($handbookData);
    }
}
