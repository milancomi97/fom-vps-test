<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
//        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'ime' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);



        $user->permission()->create([
            'role_name'=>'role_name',
            'user_id'=>$user->id,
            'osnovni_podaci'=>true,
            'obracun_zarada'=>true,
            'kadrovska_evidencija'=>true,
            'troskovna_mesta_poenter' => $this->poenterPermissionsTest()
        ]);

        event(new Registered($user));

        Auth::login($user);

        $test='test';
        return redirect(RouteServiceProvider::HOME);
    }
    public function poenterPermissionsTest()
    {
        return '{"10000000": true, "20000000": true, "21000000": true, "22000000": true, "22100000": true, "22200000": true, "22300000": true, "22400000": true, "23000000": true, "23100000": true, "23200000": true, "30000000": true, "31000000": true, "31100000": true, "31200000": true, "31300000": true, "31400000": true, "32100000": true, "32110000": false, "32120000": false, "32200000": false, "32210000": false, "32220000": false, "32230000": false, "32240000": false, "32250000": false, "32260000": false, "32270000": false, "32280000": false, "32290000": false, "32300000": false, "32310000": false, "32320000": false, "32330000": false, "32340000": false, "32400000": false, "32500000": false, "33000000": false, "33000002": false, "33100000": false, "33200000": false, "33300000": false, "40000000": false, "41000000": false, "42000000": false, "50000000": false, "60000000": false, "90000000": false, "90000001": false, "90000002": false, "90000003": false, "90000004": false}';
    }
}
