<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery as m;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        m::close();
    }
}
