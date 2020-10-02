<?php


namespace Lit\Core\Http\Controllers\Pipes;

interface Pipe
{
    public function handle($request, \Closure $next);
}
