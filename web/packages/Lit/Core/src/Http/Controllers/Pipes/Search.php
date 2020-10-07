<?php

namespace Lit\Core\Http\Controllers\Pipes;

use Illuminate\Support\Str;
use Lit\Core\Http\Controllers\QBuilder;

class Search implements Pipe
{
    public function handle($request, \Closure $next)
    {
        /** @var QBuilder $qBuilder */
        $qBuilder = $next($request);
        $searchObject = $qBuilder->request['search'];

        $builder = $qBuilder->getBuilder();
        if($search = $searchObject['value']) {
            $crud = $qBuilder->getCrudPanel();

            $columns = collect($crud->getColumns())->pluck('data');

            foreach($columns as $column) {
                $builder->orWhere($column, 'LIKE', '%' . clean_string($search) . '%');
            }

            return $qBuilder;
        } else {
            $columns = $qBuilder->request['columns'];
            foreach($columns as $column) {
                if(@$search = $column['search']['value']) {
                    if($column['search']['regex'] === 'true') {
                        $search = Str::of($search)->after('^')->before('$');
                        $builder->orWhere($column['data'], '=', stripslashes($search));
                    } else {
                        $search = clean_string($search);
                        logger($search);
                        logger($column['data']);
                        $builder->orWhere($column['data'], 'LIKE', '%' . clean_string($search) . '%');
                    }
                }
            }
        }

        return $qBuilder;
    }
}
