<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandbookRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\Handbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class PersonalController
 * @package App\Http\Controllers
 */
class PersonalController extends Controller
{
    /**
     * The authenticated user instance.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth('users')->user();

            return $next($request);
        });
    }

    /**
     * Display the user profile dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('personal.dashboard', ['user' => $this->user]);
    }

    /**
     * Update the user profile.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $this->user->update($request->validated());

        return redirect()->route('profile')->with('success', 'Профиль успешно обновлен!');
    }

    /**
     * Update the user password.
     *
     * @param  \App\Http\Requests\PasswordUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        if (!Hash::check($request->input('current_password'), $this->user->password)) {
            return redirect()->route('profile.update')->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        $this->user->update([
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('profile')->with('success_pass', 'Пароль успешно изменен!');
    }

    public function createHandbookForm()
    {
        $parentCategory = Category::where('slug', 'zivotnye')->first();
        $parentCategory2 = Category::where('slug', 'kategorii')->first();
        $animals = Category::where('parent_id', $parentCategory->id)->get();
        $categories = Category::where('parent_id', $parentCategory2->id)->get();
        $categoriesMenu = Category::whereNotIn('id', $animals->pluck('id'))
            ->whereNotIn('id', $categories->pluck('id'))
            ->get();
        return view('personal.handbook_create', ['user' => $this->user, 'categories' => $categories, 'animals' => $animals, 'categoriesMenu' => $categoriesMenu, 'parentCategory' => $parentCategory, 'parentCategory2' => $parentCategory2]);
    }

    public function updateHandbookForm(Handbook $handbook)
    {
        $handbook->load('category');
        $categories = Category::get(['id', 'name']);
        return view('personal.handbook_update', compact('handbook', 'categories'));
    }

    public function updateHandbook(HandbookRequest $request, $id)
    {
        $handbook = Handbook::findOrFail($id);
        $data = $request->validated();
        $data['client_id'] = auth('users')->id();

        $handbook->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $handbook->addMedia($file)->toMediaCollection('images');
            }
        }

        return redirect()->back()->with('success', 'Справочник успешно обновлен!');
    }
}
