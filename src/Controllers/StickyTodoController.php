<?php

namespace AhmetBarut\LaravelStickyTodos\Controllers;

use AhmetBarut\LaravelStickyTodos\Models\StickyTodo;
use Illuminate\Http\Request;

class StickyTodoController
{
    public function index()
    {
        return StickyTodo::orderBy('created_at', 'desc')
        ->orderBy('is_done', 'asc')
        ->get();
    }

    public function store(Request $request)
    {
        return StickyTodo::create($request->all());
    }

    public function update(Request $request, StickyTodo $todo)
    {
        return $todo->update($request->all());
    }

    public function destroy($todo)
    {
        $todo = StickyTodo::where('id', $todo)->first();
        $todo->delete();

        return response()->json(null, 204);
    }

    public function todoCheck($todo)
    {
        $todo = StickyTodo::findOrFail($todo);
        $todo->is_done = !$todo->is_done;
        $todo->save();

        return response()->json(null, 204);
    }
}
