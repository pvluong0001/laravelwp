<?php

namespace Lit\Core\Http\Controllers\Traits;

use Illuminate\Http\Response;
use Lit\Core\Services\CrudPanel;

/**
 * Trait ListCrud
 * @package Lit\Core\Http\Controllers\Traits
 * @property array $data
 * @property CrudPanel $crud
 */
trait DeleteCrud
{
    public function delete($id) {
        if($this->crud->cannotAccessRoute('delete')) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        $data = app()->make($this->crud->getModel())->findOrFail($id);
        $data->delete();

        flash()->success('Delete success');
        return redirect()->route($this->crud->getRouteNamePrefix() . '.index');
    }
}
