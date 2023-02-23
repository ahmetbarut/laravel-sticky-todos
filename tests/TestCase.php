<?php

namespace AhmetBarut\LaravelStickyTodos\Tests;

use AhmetBarut\LaravelStickyTodos\LaravelStickyTodosServiceProvider;
use AhmetBarut\LaravelStickyTodos\Models\StickyTodo;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__ . '/../migrations'),
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelStickyTodosServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        # Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
