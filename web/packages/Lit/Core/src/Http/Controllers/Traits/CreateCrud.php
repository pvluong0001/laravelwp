<?php

namespace Lit\Core\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lit\Core\Services\CrudPanel;

/**
 * Trait ListCrud
 * @package Lit\Core\Http\Controllers\Traits
 * @property array $data
 * @property CrudPanel $crud
 */
trait CreateCrud
{
    public function create() {
        if($this->crud->cannotAccessRoute('create')) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        if(method_exists($this, 'setupCreateUpdate')) {
            $this->setupCreateUpdate();
        }

        if(method_exists($this, 'setupCreate')) {
            $this->setupCreate();
        }

        if($this->crud->getLayoutCreateGrid()) {
            $this->crud->transformFieldsInGrid();
        }

        return view($this->crud->getCreateView(), $this->data);
    }


    public function store() {
        if($this->crud->cannotAccessRoute('create')) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        if(method_exists($this, 'setupCreate')) {
            $this->setupCreate();
        }

        /** @var Request $request */
        $request = app()->make($this->crud->getCreateRequest());

        $data = $request->validated();


        $result = app()->make($this->crud->getModel())->create($data);

        $this->crud->temp = $result;

        flash()->success('Create success!');
        return redirect()->route($this->crud->getRouteNamePrefix() . '.index');
    }
}
