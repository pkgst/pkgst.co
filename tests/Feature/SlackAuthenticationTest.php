<?php

namespace Tests\Feature;

use Illuminate\Validation\ValidationException;
use League\OAuth2\Client\Provider\GenericProvider;
use Mockery as m;
use Tests\TestCase;

class SlackAuthenticationTest extends TestCase
{
    /** @test */
    public function validation_exception_is_thrown_when_code_is_not_given()
    {
        $this->withoutExceptionHandling();

        $this->expectException(ValidationException::class);

        $this->get('/auth');
    }

    /** @test */
    public function it_authenticates_with_slack()
    {
        $this->withoutExceptionHandling();

        $mock = m::mock('\League\OAuth2\Client\Provider\GenericProvider');

        $mock->shouldReceive('getAccessToken')
            ->once()
            ->with('authorization_code', ['code' => 1234]);

        $this->app->instance(GenericProvider::class, $mock);

        $this->get('/auth?code=1234')
            ->assertStatus(302)
            ->assertRedirect('/installed');
    }
}
