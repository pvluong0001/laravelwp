<?php

namespace Lit\Core\Http\Controllers\Traits;

use Lit\Core\Services\CrudPanel;

/**
 * Trait ListCrud
 * @package Lit\Core\Http\Controllers\Traits
 * @property array $data
 * @property CrudPanel $crud
 */
trait ListCrud
{
    public function index() {
        return view($this->crud->getIndexView(), $this->data);
    }
}
