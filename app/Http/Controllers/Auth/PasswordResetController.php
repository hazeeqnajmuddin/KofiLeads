<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

/**
 * Admin "Lupa kata laluan" (forgot password) flow, built on Laravel's password broker.
 *
 * Security notes:
 * - The request step always returns the same neutral message whether or not the
 *   email exists, to avoid leaking which addresses are registered admins.
 * - Tokens are single-use, hashed at rest in `password_reset_tokens`, and expire
 *   (see config/auth.php → passwords.users.expire).
 */
class PasswordResetController extends Controller
{
    /** Show the "enter your email" form. */
    public function showLinkRequest(): View
    {
        return view('admin.auth.forgot-password');
    }

    /** Email a reset link if the address belongs to a user. Response is always neutral. */
    public function sendLink(Request $request): RedirectResponse
    {
        $request->validate(
            ['email' => ['required', 'email']],
            ['email.required' => 'Sila masukkan alamat e-mel.', 'email.email' => 'Format e-mel tidak sah.'],
        );

        Password::sendResetLink($request->only('email'));

        // Neutral response regardless of outcome (anti email-enumeration).
        return back()->with('status', 'Jika e-mel tersebut berdaftar, kami telah menghantar pautan untuk menetapkan semula kata laluan.');
    }

    /** Show the "set a new password" form reached from the emailed link. */
    public function showReset(Request $request, string $token): View
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /** Validate the token and set the new password. */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ], [
            'password.required' => 'Sila masukkan kata laluan baharu.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
            'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                // New password + fresh remember_token invalidates old "remember me" cookies.
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
                Log::info('Admin password reset completed', ['user_id' => $user->id]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')
                ->with('status', 'Kata laluan berjaya ditetapkan semula. Sila log masuk.');
        }

        return back()
            ->withErrors(['email' => match ($status) {
                Password::INVALID_TOKEN => 'Pautan tetapan semula tidak sah atau telah tamat tempoh. Sila minta pautan baharu.',
                Password::INVALID_USER => 'Kami tidak dapat memproses permintaan ini.',
                default => 'Ralat berlaku semasa menetapkan semula kata laluan. Sila cuba lagi.',
            }])
            ->withInput($request->only('email'));
    }
}
