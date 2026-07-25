<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(): View
    {
        return view('admin.akaun', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (! Hash::check($value, $user->password)) {
                        $fail('Kata laluan semasa tidak betul.');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Sila masukkan kata laluan semasa.',
            'password.required' => 'Sila masukkan kata laluan baharu.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
            'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Kata laluan berjaya dikemaskini.');
    }
}
