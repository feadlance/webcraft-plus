<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helpers\PasswordHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'username' => 'required|username|max:16|unique:users',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        if ( settings('recaptcha.public_key') && settings('recaptcha.private_key') ) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        return Validator::make($data, $rules)->setAttributeNames([
            'username' => __('Kullanıcı Adı'),
            'email' => __('E-Posta'),
            'password' => __('Şifre'),
            'password_confirmation' => __('Şifre Tekrarı'),
            'g-recaptcha-response' => 'ReCaptcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        $passwordHelper = new PasswordHelper(settings('lebby.password_encryption'));

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $passwordHelper->hash($data['password']),
            'isAdmin' => isset($data['isAdmin']) && $data['isAdmin'] === true
        ]);
    }
}
