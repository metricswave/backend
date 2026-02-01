<?php

it('returns 410 gone because signups are disabled', function () {
    $this
        ->postJson('/api/signup', [
            'name' => 'Victor',
            'email' => 'victoor89@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'test',
        ])
        ->assertStatus(410)
        ->assertJson([
            'message' => 'MetricsWave is shutting down. New registrations are no longer accepted. The service will be discontinued in June 2025.',
        ]);
});
