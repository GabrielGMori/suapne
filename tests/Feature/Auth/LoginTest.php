<?php

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('login page is accessible to guests', function () {
    $response = $this->get(route('login.index'));

    $response->assertStatus(200);
});

test('user can authenticate with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'teste@ifpr.edu.br',
        'password' => Hash::make('senha12345'),
        'role' => RoleEnum::DOCENTE_ESPECIAL,
    ]);

    $response = $this->post(route('login'), [
        'email' => 'teste@ifpr.edu.br',
        'password' => 'senha12345',
    ]);

    $response->assertRedirect(route('dashboard.index'));
    $this->assertAuthenticatedAs($user);
});

test('user cannot authenticate with invalid password', function () {
    User::factory()->create([
        'email' => 'teste@ifpr.edu.br',
        'password' => Hash::make('senhaCorreta'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'teste@ifpr.edu.br',
        'password' => 'senhaIncorreta',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('credentials');
    $this->assertGuest();
});

test('authenticated user can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('login.index'));
    $this->assertGuest();
});
