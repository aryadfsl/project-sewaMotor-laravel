<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function tets_google_redirect_route()
    {
        $response = $this->get('/auth/google/redirect');
        $response->assertStatus(302);
    }
}
