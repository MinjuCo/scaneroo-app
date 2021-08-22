<?php

namespace App\Http\Controllers;

use App\Contracts\LanguageRepository;
use App\Contracts\UserRepository;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

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
        return view('home', [
            'user' => (auth()->user())?auth()->user():[],
        ]);
    }

    /**
     * Check username availability
     */
    public function checkUsername($username){
        $data = [];
        if($this->userRepo->findByUsername($username)){
            $data = ["message" => 'Username is already in use.', "code" => "AlreadyExists"];
        }else{
            $data = ["message" => 'Username is available.', "code" => "OK"];
        }

        return response()->json($data);
    }

    public function register(Request $request){

        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = ($request->input('password')) ? Hash::make($request->input('password')) : Hash::make(Str::random(12));
        
        if($request->input('id')) $user->google_id = $request->input('id');

        $user->avatar = $request->input('avatar');
        $user->learning_lang = $request->input('learning_lang');
        $user->interface_lang = App::currentLocale();
        $user->birthday = $request->input('birthday');
        $user->membership = $request->input('role');
        $user->register_completed = true;

        $this->userRepo->insert($user);

        Auth::login($user);

        return view('home', [
            'user' => (auth()->user())?auth()->user():[],
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json('Logged in');
        }

        return response()->json('Login failed');

    }

    public function update(Request $request, $id){
        if($id != Auth::id()){
            $data = [
                'message' => "No access to update this user."
            ];
            return response()->json($data,401);
        }

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->birthday = $request->input('birthday');
        $user->learning_lang = $request->input('learning_lang');
        $user->interface_lang = $request->input('interface_lang');
        $this->userRepo->insert($user);

        $languages = app(LanguageRepository::class);
        $languages = Arr::pluck($languages->active('interface'), 'lang_code');
        
        if (! in_array($request->input('interface_lang'), $languages)) {
            response()->json('Failed to update profile', 404);
        }

        return response()->json('Profile updated', 200);

    }

    public function getBadges($id){
        return User::find($id)->badges()->get();
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
