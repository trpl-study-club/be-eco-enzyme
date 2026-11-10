<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test root URL redirects to admin.
     */
    public function test_root_redirects_to_admin(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('admin.dashboard'));
    }
}
