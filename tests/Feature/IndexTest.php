<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_landing_page_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('main.index'); // Update if different
    }
}
