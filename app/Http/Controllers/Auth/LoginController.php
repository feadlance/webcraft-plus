<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\PasswordHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => [
            'setEmail',
            'postSetEmail',
            'logout'
        ]]);
    }

    /**
     * Change 'email' to 'username' for login.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect('/login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required',
            'password' => 'required',
        ])->setAttributeNames([
            $this->username() => __('Kullanıcı Adı'),
            'password' => __('Şifre')
        ]);

        if ( $validator->fails() ) {
            return redirect('/login')
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($validator);
        } 
    }

    /**
     * Custom login handler.
     */
    public function customLogin(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = User::where(
            $this->username(),
            $request->input($this->username())
        )->first();

        if ( $user !== null ) {

            $passwordHelper = new PasswordHelper(settings('lebby.password_encryption'));

            if ( $passwordHelper->check($request->password, $user->password) ) {
                auth()->login($user);

                return $this->sendLoginResponse($request);
            }

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Display set new e-mail page.
     */
    public function setEmail()
    {
        return view('auth.set-email');
    }

    /**
     * Set new e-mail.
     */
    public function postSetEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191|unique:users'
        ])->setAttributeNames([
            'email' => __('e-Posta')
        ])->validate();

        $user = $request->user();

        $user->email = request('email');
        $user->save();

        return redirect()->route('home')
            ->with('flash.success', __('e-Posta adresiniz başarıyla kaydedildi. Sunucunun keyfini çıkarın!'));
    }
}
