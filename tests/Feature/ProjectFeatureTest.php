<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProjectFeatureTest extends TestCase
{
    public function test_login_page_returns_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_google_redirect_route_returns_redirect_response(): void
    {
        config([
            'services.google.client_id' => 'fake-google-client-id',
            'services.google.client_secret' => 'fake-google-client-secret',
            'services.google.redirect' => 'http://localhost/auth/google/callback',
        ]);

        $response = $this->get('/auth/google/redirect');

        $response->assertStatus(302);
    }
}
