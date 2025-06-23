<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\System;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;




class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    // public function create()
    // {
    //     return view('auth.register');
    // }
    public function create()
    {
        $roles = System::where('system_type', 'combo')
            ->where('system_sub_type', 'role')
            ->get();

        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }

    public function store(Request $request)
    {
        $phone = $request->input('phone');

        // Normalisasi: ganti awalan 62 → 0
        $phone = preg_replace('/^62/', '0', $phone);

        // Inject nomor hasil normalisasi ke request
        $request->merge(['phone' => $phone]);

        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => [
                'required',
                'string',
                'max:15',
                'unique:users,phone',
                'regex:/^(0)[0-9]{8,14}$/', // wajib mulai dari 0
            ],
            'role' => 'required|string',
            'password' => 'required|string|confirmed|min:3|max:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
