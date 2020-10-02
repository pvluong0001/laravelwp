<?php

namespace Lit\Core\Http\Controllers\Pipes;

class Filter implements Pipe
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
