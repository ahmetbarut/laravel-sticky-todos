<?php

use AhmetBarut\LaravelStickyTodos\Controllers\StickyTodoController;
use AhmetBarut\LaravelStickyTodos\Models\StickyTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('api/' . config('sticky-todos.router_prefix') . '/todos', [StickyTodoController::class, 'index']);

Route::post('api/' . config('sticky-todos.router_prefix') . '/todos', [StickyTodoController::class, 'store']);

Route::delete('api/' . config('sticky-todos.router_prefix') . '/todos/{todo}', [
    StickyTodoController::class,
    'destroy'
]);

Route::put('api/' . config('sticky-todos.router_prefix') . '/todos-check/{todo}', [
    StickyTodoController::class,
    'todoCheck'
]);
