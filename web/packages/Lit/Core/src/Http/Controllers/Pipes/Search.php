<?php

namespace Lit\Core\Http\Controllers\Pipes;

use Lit\Core\Http\Controllers\QBuilder;

class Search implements Pipe
{
    public function handle($request, \Closure $next)
    {
        if($search = request()->get('s')) {
            /** @var QBuilder $qBuilder */
            $qBuilder = $next($request);
            $builder = $qBuilder->getBuilder();
            $crud = $qBuilder->getCrudPanel();

            $columns = collect($crud->getColumns())->pluck('name');
            foreach($columns as $column) {
                $builder->orWhere($column, 'LIKE', '%' . clean_string($search) . '%');
            }

            return $qBuilder;
        }

        return $next($request);
    }
}
