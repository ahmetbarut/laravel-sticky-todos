<?php

namespace AhmetBarut\LaravelStickyTodos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StickyTodo extends Model
{
    use HasFactory;

    protected $table = 'todo_sticky_notes';

    protected $fillable = [
        'title',
        'description',
        'is_done',
        'due_date',
    ];
}
