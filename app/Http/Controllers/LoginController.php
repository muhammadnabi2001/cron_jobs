<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessage;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginpage()
    {
        return view('Login.login');
    }
    public function registerpage()
    {
        return view('Register.register');
    }
    public function login(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {


            return view('index');
        } else {
            return redirect()->back();
        }
    }
    public function register(Request $request)
    {
        //dd(123);
        $data = $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|max:50|min:5|email|unique:users,email',
            'password1' => 'required',
            'password2' => 'required|same:password1'
        ]);

        $data['password'] = bcrypt($data['password1']);
        unset($data['password1'], $data['password2']);

        $user = User::create($data);
        Auth::login($user);
        $code = rand(1000, 9999);
        VerifyUser::create([
            'user_id' => Auth::id(),
            'code' => $code
        ]);
        SendMessage::dispatch($user, $code);

        return view('Register.check')->with('success', 'Ro\'yxatdan o\'tish muvaffaqiyatli yakunlandi!');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/loginpage');
    }
    public function confirmation(Request $request)
    {
        //  dd($request->code);
        $request->validate([
            'code' => 'required|digits:4',
        ]);
        $userId = Auth::id();
        $codeVerify = VerifyUser::where('user_id', $userId)
            ->where('code', $request->code)
            ->first();
        if ($codeVerify) {
            $user = User::find($userId);
            $user->email_verified_at = now();
            $user->save();
            return view('index')->with('success', 'Your verification code is correct!');
        } else {
            return redirect()->route('confirmation')->with('error', 'Invalid verification code!');
        }
    }
}
