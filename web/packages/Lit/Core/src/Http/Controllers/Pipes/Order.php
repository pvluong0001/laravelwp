<?php

namespace Lit\Core\Http\Controllers\Pipes;

use Lit\Core\Http\Controllers\QBuilder;

class Order implements Pipe
{
    public function handle($request, \Closure $next)
    {
        /** @var QBuilder $qBuilder */
        $qBuilder = $next($request);
        $orders = $qBuilder->request['order'];
        $columns = $qBuilder->request['columns'];

        if(!empty($orders)) {
            $builder = $qBuilder->getBuilder();

            foreach($orders as $order) {
                $builder->orderBy($columns[$order['column']]['data'], $order['dir']);
            }

            return $qBuilder;
        }

        return $qBuilder;
    }
}
