<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\notifiable;
use App\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if($request->step == 1) {
            $rules = [
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'phoneNumber' => 'required|numeric|digits:12',
                'email' => 'required|email|unique:App\User,user_mail',
            ];

            $messages = [
                'firstName.required' => 'Kolom nama depan harus diisi.',
                'lastName.required' => 'Kolom nama belakang harus diisi.',
                'phoneNumber.required' => 'Kolom nomor telepon harus diisi.',
                'phoneNumber.numeric' => 'Nomor telepon harus diisi dengan angka.',
                'phoneNumber.digits' => 'Kolom nomor telepon harus 12 digit.',
                'email.required' => 'Kolom email harus diisi.',
                'email.email' => 'Format email harus valid.',
                'email.unique' => 'Email ini sudah terdaftar.',
            ];

            $this->validate($request, $rules, $messages);
            return response(['response' => 'continue']);;
        }

        if($request->step == 2) {
            $rules = [
                'password' => 'required|min:6',
            ];
            
            $messages = [
                'password.required' => 'Kolom password harus diisi.',
                'password.min' => 'Minimal karakter pada password adalah 6.',
            ];
            
            $this->validate($request, $rules, $messages);
            
            $userRegister = new User;
            $userRegister->user_name = ucfirst($request->firstName).' '.ucfirst($request->lastName);
            $userRegister->user_mail = $request->email;
            $userRegister->user_phone = $request->phoneNumber;
            $userRegister->user_password = bcrypt($request->password);
            $userRegister->user_is_active = 1;
            
            $file = $request -> file('image');

            if ($file == null) {
                $userRegister ->user_foto = 'default.png';
            }else {
                $ext = $request->file('image')->getClientOriginalExtension();
                $current_timestamp = now()->timestamp;
                $imageFile = $current_timestamp.'.'.$ext;
                $userRegister->user_foto = $imageFile;
                $request->file('image')->storeAs('public/profile', $current_timestamp.'.'.$ext);
            }

            $userRegister -> save();

            return response(['response' => 'success', 'message' => 'Registrasi akun berhasil!']);
        }
    }
    
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        
        $messages = [
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email harus valid.',
            'password.required' => 'Kolom password harus diisi.',
        ];

        $userLoggingIn = new User;
        $userLoggingIn = $this->validate($request, $rules, $messages);

        if(!Auth::attempt(['user_mail' => $userLoggingIn['email'], 'password' => $userLoggingIn['password']])) {
            return response(['user' => '', 'loggedin' => false, 'message' => 'Email atau password yang dimasukkan salah.']);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        $isAdmin = false;
        if(Auth::user()->user_is_admin == 1)
            $isAdmin = true;
            
        return response(['user' => Auth::user(), 'loggedin' => true, 'isadmin' => $isAdmin, 'access_token' => $accessToken]);
    }

    public function currentUser()
    {
        $isAdmin = false;
        if(Auth::user()->user_is_admin == 1)
            $isAdmin = true;
            
        return response(['user' => Auth::user(), 'loggedin' => true, 'isadmin' => $isAdmin]);
    }
}
