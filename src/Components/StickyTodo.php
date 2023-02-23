<?php

namespace AhmetBarut\LaravelStickyTodos\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StickyTodo extends Component
{
    private ?array $config;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $config = config('sticky-todos');
        unset($config['users']);
        $this->config = $config;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('sticky-todos-views::todo-sticky-note')->with([
            'config' => json_encode($this->config),
        ]);
    }
}
