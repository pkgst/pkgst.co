<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /** @test */
    public function it_finds_a_package_by_its_full_name()
    {
        $responseBody = file_get_contents(__DIR__.'/../stubs/packagist-response-full-namespace.json');

        $mockHandler = new MockHandler([
            new Response(200, [], $responseBody),
        ]);

        $handler = HandlerStack::create($mockHandler);

        $this->app->instance(
            Client::class,
            new Client(['handler' => $handler])
        );

        $expectedResponse = json_decode(
            file_get_contents(__DIR__.'/../stubs/slack-request.json'),
            true
        );

        $this->post('/api/search', ['text' => 'sven/artisan-view'])
            ->assertExactJson($expectedResponse);
    }

    /** @test */
    public function it_finds_a_package_by_query()
    {
        $responseBody = file_get_contents(__DIR__.'/../stubs/packagist-response-simple-query.json');

        $mockHandler = new MockHandler([
            new Response(200, [], $responseBody),
        ]);

        $handler = HandlerStack::create($mockHandler);

        $this->app->instance(
            Client::class,
            new Client(['handler' => $handler])
        );

        $expectedResponse = json_decode(
            file_get_contents(__DIR__.'/../stubs/slack-request.json'),
            true
        );

        $this->post('/api/search', ['text' => 'artisan-view'])
            ->assertExactJson($expectedResponse);
    }

    /** @test */
    public function it_notifies_the_user_if_package_could_not_be_found_by_full_name()
    {
        $responseBody = file_get_contents(__DIR__.'/../stubs/packagist-response-not-found.json');

        $mockHandler = new MockHandler([
            new Response(404, [], $responseBody),
        ]);

        $handler = HandlerStack::create($mockHandler);

        $this->app->instance(
            Client::class,
            new Client(['handler' => $handler, 'http_errors' => false])
        );

        $expectedResponse = json_decode(
            file_get_contents(__DIR__.'/../stubs/slack-request-not-found.json'),
            true
        );

        $this->post('/api/search', ['text' => 'inv alid/name goes - h_r_'])
            ->assertExactJson($expectedResponse);
    }

    /** @test */
    public function it_notifies_the_user_if_package_could_not_be_found_by_search_term()
    {
        $responseBody = file_get_contents(__DIR__.'/../stubs/packagist-response-not-found.json');

        $mockHandler = new MockHandler([
            new Response(404, [], $responseBody),
        ]);

        $handler = HandlerStack::create($mockHandler);

        $this->app->instance(
            Client::class,
            new Client(['handler' => $handler, 'http_errors' => false])
        );

        $expectedResponse = json_decode(
            file_get_contents(__DIR__.'/../stubs/slack-request-not-found.json'),
            true
        );

        $this->post('/api/search', ['text' => 'a search term that does not result in any hits'])
            ->assertExactJson($expectedResponse);
    }
}
