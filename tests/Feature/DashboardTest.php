<?php

use App\Models\User;

test('authenticated users can visit the dashboard', function () {
    // Create a verified user
    $user = User::factory()->create([
        'role' => 1,                  // optional if your dashboard checks role
        'email_verified_at' => now(), // mark as verified
    ]);

    $this->actingAs($user);

    $this->get('/dashboard')->assertStatus(200);
});

