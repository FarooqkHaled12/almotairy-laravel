<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('data-lead-open')
            ->assertSee('id="header"', false)
            ->assertSee('shared-layout.css?v=', false);
    }

    public function test_lead_capture_is_available_across_public_pages(): void
    {
        foreach (['/about-us', '/services', '/contact', '/all-properties'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('data-lead-open')
                ->assertSee('id="header"', false)
                ->assertSee('shared-layout.css?v=', false);
        }
    }
}
