<?php

namespace Lit\Core\Http\Controllers\Traits;

use Illuminate\Pipeline\Pipeline;
use Lit\Core\Http\Controllers\Pipes\Filter;
use Lit\Core\Http\Controllers\Pipes\Limit;
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
        $qBuilder = new QBuilder(
            app()->make($this->crud->getModel())->query(),
            $this->crud
        );

        /** @var Pipeline $pipeline */
        $qBuilder = app(Pipeline::class)
            ->send($qBuilder)
            ->through([
                Filter::class,
                Search::class
            ])
            ->thenReturn();

        $data = $qBuilder->getBuilder()->paginate(1);

        if($this->crud->getAssets()) {
            return $data;
        }

        $this->data['data'] = $data;

        return view($this->crud->getListView(), $this->data)->render();
    }
}
