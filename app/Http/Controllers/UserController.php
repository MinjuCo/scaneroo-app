<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    /**
     * Redirect to Google login
     * 
     * @return void
     */
    public function socialSignUp($provider)
    {
        $json = null;
        try {
            $user = Socialite::driver($provider)->stateless()->user();

            $findUser = User::where('google_id', $user->id)->first();

            if($findUser){
                Auth::login($findUser);

                $json = [
                    'isLoggedIn' => true,
                    'completed' => $findUser->register_completed,
                    'user' => $findUser
                ];
            }else{

                $json = [
                    'isLoggedIn' => false,
                    'completed' => false,
                    'user' => $user
                ];
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        

        return response()->json($json);
    }

    /**
     * Handle Google Login
     * 
     * @return void
     */
    public function handleCallback()
    {
        return view('home');
    }
}
