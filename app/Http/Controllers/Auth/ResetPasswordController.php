<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'email.required' => __('validation.required', ['attribute' => __('E-Posta')]),
            'email.email' => __('validation.email', ['attribute' => __('E-Posta')]),
            'password.required' => __('validation.required', ['attribute' => __('Şifre')]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => __('Şifre')]),
            'password.min' => __('validation.min.string', ['attribute' => __('Şifre'), 'min' => '6']),
        ];
    }
}
