<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Client;
use App\Services\AccountConfirmationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $confirmationService;

    /**
     * AuthController constructor.
     *
     * @param AccountConfirmationService $confirmationService
     */
    public function __construct(AccountConfirmationService $confirmationService)
    {
        $this->confirmationService = $confirmationService;
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm()
    {
        if (auth('users')->check()) {
            return redirect(route('home'));
        }
        Session::put('previousUrl', url()->previous());
        return view('personal.login');
    }

    /**
     * Handle the user login request.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        $user = auth('users')->getProvider()->retrieveByCredentials($credentials);
        if (!empty($user) && !$user->confirmed) {
            return redirect(route('login'))
                ->withErrors(['incorrect' => 'Учетная запись не активна, проверьте электронную почту.']);
        }

        if (auth('users')->attempt($credentials, $remember)) {
            $previousUrl = Session::pull('previousUrl', route('home'));
            return redirect($previousUrl);
        } else {
            return redirect(route('login'))
                ->withErrors(['incorrect' => 'Проверьте правильность заполненных полей']);
        }
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRegistrationForm()
    {
        if (auth('users')->check()) {
            return redirect(route('home'));
        }

        return view('personal.register');
    }

    /**
     * Handle the user registration request.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = Client::create([
            'type' => $request->input('type'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'confirmation_token' => Str::random(64),
        ]);

        $this->confirmationService->sendConfirmationEmail($user);

        return redirect(route('confirm.form'));
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth('users')->logout();
        return redirect(route('login'));
    }

    /**
     * Show the account confirmation form.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showConfirmForm()
    {
        if (auth('users')->check()) {
            return redirect(route('home'));
        }

        return view('personal.confirm_form');
    }

    /**
     * Confirm the user account with the given token.
     *
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm($token)
    {
        $user = Client::where('confirmation_token', $token)->firstOrFail();

        $this->confirmationService->confirmAccount($user);

        auth('users')->login($user);

        return redirect(route('home'));
    }
}
