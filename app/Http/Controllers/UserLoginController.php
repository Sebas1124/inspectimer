<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OTPMailable;
use App\Models\OtpUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserLoginController extends Controller
{
    public function index (){
        return view('auth.login-otp');
    }

    public function verify(Request $request){
        $email = $request->email;
        $password = $request->password;

        $user = User::Where('email', $email)->first();

        if( $user ){

            $hashPassword = Hash::check($password, $user->password);

            if ($hashPassword) {

                $otp = rand(100000, 999999);

                OtpUsers::create([
                    'userId' => $user->id,
                    'otpCode' => $otp,
                    'approved' => NULL
                ]);

                Mail::to($user->email)->send(new OTPMailable($user, $otp));
                
                return view('auth.otp', compact('user', 'password'));

            }

        }

        return redirect()->route('login.otp')->with('error', 'Credenciales incorrectas');

    }

    public function confirm(Request $request){
        $otp = $request->otp;
        $userEmail = $request->email;

        $user = User::Where('email', $userEmail)->first();

        $otpUser = OtpUsers::Where('userId', $user->id)->Where('otpCode', $otp)->latest()->first();

        if ($otpUser) {
            $otpUser->approved = 'Approved';
            $otpUser->save();

            return json_encode(['status' => 'Exitoso codigo otp correcto']);
        }

        throw new \Exception('Codigo OTP incorrecto');
    }
}
