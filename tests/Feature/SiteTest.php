<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSiteIsWorking()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
