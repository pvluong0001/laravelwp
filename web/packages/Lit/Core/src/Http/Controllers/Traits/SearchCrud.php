<?php

namespace Lit\Core\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Lit\Core\Http\Controllers\Pipes\Filter;
use Lit\Core\Http\Controllers\Pipes\Limit;
use Lit\Core\Http\Controllers\Pipes\Order;
use Lit\Core\Http\Controllers\Pipes\Search;
use Lit\Core\Http\Controllers\QBuilder;
use Lit\Core\Services\CrudPanel;

/**
 * Trait SearchCrud
 * @package Lit\Core\Http\Controllers\Traits
 * @property CrudPanel $crud
 */
trait SearchCrud
{
    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function search() {
        /** @var Request $request */
        $request = app()->make($this->crud->getSearchRequest());

        $qBuilder = new QBuilder(
            app()->make($this->crud->getModel())->query(),
            $this->crud,
            $request->validated()
        );

        /** @var Pipeline $pipeline */
        $qBuilder = app(Pipeline::class)
            ->send($qBuilder)
            ->through([
                Filter::class,
                Search::class,
                Order::class
            ])
            ->thenReturn();

        /** @var LengthAwarePaginator $data */
        $data = $qBuilder->getBuilder()->paginate(request()->get('length'));

        if($this->crud->getAssets()) {
            return $this->_convertData($data, app()->make($this->crud->getModel())->count());
        }

        $this->data['data'] = $data;

        return view($this->crud->getListView(), $this->data)->render();
    }

    private function _convertData(LengthAwarePaginator $lengthAwarePaginator, int $totalRecords) {
        return [
            'draw' => (int) request()->get('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $lengthAwarePaginator->total(),
            'data' => $lengthAwarePaginator->items()
        ];
    }
}
