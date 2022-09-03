<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\User;
use App\User_verify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'login',
        ];
        return view('auth.login', $data);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Register',
        ];
        return view('auth.register', $data);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->roles == 'Admin') {
                return redirect('/admin')
                    ->with('sukses', 'You have Successfully loggedin');
            } else {
                return redirect('/user/dashboard')
                    ->with('sukses', 'You have Successfully loggedin');
            }
        }

        return redirect("login")->with('error', 'Oppes! You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $createUser = $this->create($data);

        $token = Str::random(64);

        User_verify::create([
            'user_id' => $createUser->id,
            'token' => $token
        ]);

        Mail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Email Verification Mail');
        });
        return redirect('/login')->with('sukses', 'Great! You have Successfully loggedin');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verifyAccount($token)
    {
        $verifyUser = User_verify::where('token', $token)->first();
        // dd($verifyUser->user)
        $message = 'Sorry your email cannot be identified.';

        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;

            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return redirect()->route('login')->with('message', $message);
    }
}
