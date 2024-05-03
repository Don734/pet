<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordResetUpdateRequest;
use App\Services\PasswordResetService;

class ForgotPasswordController extends Controller
{
    /**
     * The PasswordResetService instance.
     *
     * @var \App\Services\PasswordResetService
     */
    protected $passwordResetService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\PasswordResetService  $passwordResetService
     * @return void
     */
    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Display the form to request password reset.
     *
     * @return \Illuminate\View\View
     */
    public function showForgetPasswordForm()
    {
        return view('personal.forget_password');
    }

    /**
     * Submit the form to request password reset.
     *
     * @param  \App\Http\Requests\PasswordResetRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForgetPasswordForm(PasswordResetRequest $request)
    {
        $this->passwordResetService->sendPasswordResetEmail($request->email);
        return back()->with('success_restore', 'Мы отправили вам почту с ссылкой на восстановление пароля!');
    }

    /**
     * Display the form to reset password with the given token.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm($token) {
        return view('personal.reset_password', ['token' => $token]);
    }

    /**
     * Submit the form to update/reset password.
     *
     * @param  \App\Http\Requests\PasswordResetUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitResetPasswordForm(PasswordResetUpdateRequest $request)
    {
        $result = $this->passwordResetService->resetPassword(
            $request->email,
            $request->token,
            $request->password
        );

        if ($result) {
            return redirect()->route('login')->with('success_restore', 'Ваш пароль был изменен, вы можете авторизоваться под новым!');
        } else {
            return back()->withInput()->with('error', 'Неверный токен безопасности!');
        }
    }
}
