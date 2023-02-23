<?php

use AhmetBarut\LaravelStickyTodos\Models\StickyTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('api/' . config('sticky-todos.router_prefix') . '/todos', function (Request $request) {
    return StickyTodo::orderBy('created_at', 'desc')
        ->orderBy('is_done', 'asc')
        ->get();
});

Route::post('api/' . config('sticky-todos.router_prefix') . '/todos', function (Request $request) {
    $todo = StickyTodo::create($request->all());
    return $todo;
});

Route::delete('api/' . config('sticky-todos.router_prefix') . '/todos/{todo}', function (StickyTodo $todo) {
    $todo->delete();
    return $todo;
});

Route::put('api/' . config('sticky-todos.router_prefix') . '/todos-check/{todo}', function (StickyTodo $todo, Request $request) {
    $todo->is_done = $request->is_done;
    $todo->save();
    return $todo;
});
