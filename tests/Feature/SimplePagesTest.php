<?php

namespace Tests\Feature;

use Tests\TestCase;

class SimplePagesTest extends TestCase
{
    /** @test */
    public function home_gives_200()
    {
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function installed_gives_200()
    {
        $this->get('/installed')->assertStatus(200);
    }

    /** @test */
    public function privacy_gives_200()
    {
        $this->get('/privacy')->assertStatus(200);
    }

    /** @test */
    public function support_gives_200()
    {
        $this->get('/support')->assertStatus(200);
    }
}
