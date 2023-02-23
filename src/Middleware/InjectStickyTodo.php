<?php

namespace AhmetBarut\LaravelStickyTodos\Middleware;

use AhmetBarut\LaravelStickyTodos\Components\StickyTodo as ComponentsStickyTodo;
use App\View\Components\StickyTodo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\Response;

class InjectStickyTodo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $response->setContent(
                $content = str($response->getContent())
                    ->explode('</body>')
                    ->prepend(
                        Blade::renderComponent(new ComponentsStickyTodo())
                    )
                    ->implode('</body>')
            );
            $response->setContent($content);
        }

        return $response;
    }
}
