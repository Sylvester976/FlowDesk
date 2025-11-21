<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    // Create a verified user
    $user = User::factory()->create([
        'email_verified_at' => now(), // mark email as verified
    ]);

    $this->actingAs($user);

    $this->get('/dashboard')->assertStatus(200);
});
