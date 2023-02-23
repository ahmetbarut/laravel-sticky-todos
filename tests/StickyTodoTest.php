<?php

namespace AhmetBarut\LaravelStickyTodos\Tests;

use AhmetBarut\LaravelStickyTodos\Models\StickyTodo;
use AhmetBarut\LaravelStickyTodos\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StickyTodoTest extends TestCase
{
    public function testCreateTodo()
    {
        $prefix = config('sticky-todos.router_prefix');

        $this->post("api/{$prefix}/todos", [
            'title' => 'Test Todo',
            'description' => 'Test Description',
        ])->assertStatus(201);
    }

    public function testDeleteTodo()
    {
        $prefix = config('sticky-todos.router_prefix');

        $todo = StickyTodo::create([
            'title' => 'Test Todo',
            'description' => 'Test Description',
        ]);

        $this->delete("api/{$prefix}/todos/{$todo->id}")->assertStatus(200);
    }

    public function testCheckTodo()
    {
        $prefix = config('sticky-todos.router_prefix');

        $todo = StickyTodo::create([
            'title' => 'Test Todo',
            'description' => 'Test Description',
        ]);

        $this->put("api/{$prefix}/todos-check/{$todo->id}", [
            'is_done' => true,
        ])->assertStatus(200);
    }

    public function testGetTodos()
    {
        $prefix = config('sticky-todos.router_prefix');

        $this->get("api/{$prefix}/todos")->assertStatus(200);
    }
}
