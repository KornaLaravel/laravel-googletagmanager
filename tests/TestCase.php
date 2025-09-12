<?php

namespace Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Spatie\GoogleTagManager\GoogleTagManagerServiceProvider;

class TestCase extends TestbenchTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            GoogleTagManagerServiceProvider::class,
        ];
    }
}
