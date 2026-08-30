<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate(['email' => ['required','email','max:200','exists:users,email']]);

        $status = Password::sendResetLink($request->only('email'));
        session(['forgot_password_email' => $validated['email']]);

        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['status' => __($status)]);
    }

    public function resetPasswordForm(string $token)
    {
        $email = session('forgot_password_email');
        if (!$email) return redirect()->route('password.forgot')->withErrors(['email' => 'Um erro ocorreu, tente novamente']);

        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required','email','max:200','exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:200', 'confirmed'],
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user->forceFill(['password' => Hash::make($password)]);
            $user->save();
            event(new PasswordReset($user));
        });

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->with('status', __($status));
    }
}
