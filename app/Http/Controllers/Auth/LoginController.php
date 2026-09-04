<?php

namespace App\Http\Controllers\Auth;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index');
        }

        return redirect()->route('login')->withErrors(['credentials' => 'As credenciais inseridas são inválidas']);
    }

    public function logout(Request $request) : RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }

    public function demoLogin(Request $request) : RedirectResponse
    {
        $role = RoleEnum::from($request->input('role'));

        $account = match ($role) {
            RoleEnum::DOCENTE_ESPECIAL => 'admin@exemplo.com',
            RoleEnum::PROFESSOR_REGULAR => 'professor@exemplo.com',
            RoleEnum::TECNICO => 'tecnico@exemplo.com',
            default => throw ValidationException::withMessages(['role' => 'Função inválida'])
        };

        Auth::login(User::where('email', $account)->first());
        $request->session()->regenerate();

        return redirect()->route('dashboard.index');
    }
}
