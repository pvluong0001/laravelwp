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
trait UpdateCrud
{
    public function edit($id) {
        if($this->crud->cannotAccessRoute('update')) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        if(method_exists($this, 'setupCreateUpdate')) {
            $this->setupCreateUpdate();
        }

        if(method_exists($this, 'setupUpdate')) {
            $this->setupUpdate();
        }

        $data = app()->make($this->crud->getModel())->findOrFail($id);
        $this->crud->setData($data);

        return view($this->crud->getEditView(), $this->data);
    }

    public function update($id) {
        if($this->crud->cannotAccessRoute('update')) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        if(method_exists($this, 'setupUpdate')) {
            $this->setupUpdate();
        }

        /** @var Request $request */
        $request = app()->make($this->crud->getUpdateRequest());

        $data = $request->validated();

        $model = app()->make($this->crud->getModel())->findOrFail($id);
        $model->update($data);

        $this->crud->temp = $model;

        flash()->success('Update success!');
        return redirect()->route($this->crud->getRouteNamePrefix() . '.index');
    }
}
