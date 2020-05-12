<?php

declare(strict_types=1);

namespace Note\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Note\Src\Auth\Authenticator;
use Sirius\Validation\Validator;
use Tamtamchik\SimpleFlash\Flash;

class AuthController
{
    /**
     * @var Authenticator
     */
    private $auth;

    /**
     * @param Authenticator $auth
     */
    public function __construct(Authenticator $auth)
    {
        $this->auth = $auth;
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Validator $validator, Request $request, Flash $flash)
    {
        $validator->add([
            'email:Email' => 'required | email',
            'password:Password' => 'required | minlength(5) | maxlength(25)'
        ]);

        if ($validator->validate($request->all())) {
            if ($this->auth->login($request->email, $request->password)) {
                $flash->message('Welcome back!');
                return redirect()->route('home');
            }
            $validator->addMessage('Fail', 'These credentials do not match our records.');
        }

        return view('auth.login', [
            'errors' => $validator->getMessages(),
            'email'  => $request->email
        ]);
    }

    public function getLogout()
    {
        $this->auth->logout();
        return redirect()->route('home');
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Validator $validator, Request $request, Flash $flash)
    {
        $validator->add([
            'email:Email' =>
            'required | email | minlength(8) | maxlength(50) | unique(users,email)',
            'password:Password' =>
            "required | minlength(5) | maxlength(25) | 
             match(password_confirm)(The {label} confirmation doesn't match.)"
        ]);

        if ($validator->validate($request->all())) {
            if ($this->auth->register($request->only(['email', 'password']))) {
                $flash->message('Registration successful!');
                return redirect()->route('home');
            }
        }

        return view('auth.register', [
            'errors' => $validator->getMessages(),
            'email'  => $request->email
        ]);
    }
}
