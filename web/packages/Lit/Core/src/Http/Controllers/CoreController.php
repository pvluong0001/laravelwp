<?php

namespace Lit\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Lit\Core\Http\Controllers\Traits\CreateCrud;
use Lit\Core\Http\Controllers\Traits\DeleteCrud;
use Lit\Core\Http\Controllers\Traits\ListCrud;
use Lit\Core\Http\Controllers\Traits\SearchCrud;
use Lit\Core\Http\Controllers\Traits\UpdateCrud;
use Lit\Core\Services\CrudPanel;

/**
 * Class CoreController
 * @package Lit\Core\Http\Controllers
 * @method void setup Setup for crud
 * @property CrudPanel $crud
 * @method mixed setupCreateUpdate
 * @method mixed setupCreate
 * @method mixed setupUpdate
 */
class CoreController extends Controller
{
    use ListCrud, SearchCrud, CreateCrud, UpdateCrud, DeleteCrud;

    protected $crud;
    protected $data = [];

    public function __construct()
    {
        $this->crud = app()->make(CrudPanel::class);
        $this->data['crud'] = $this->crud;
        $this->setup();

        $classBasename = Str::of(class_basename($this))->before('Controller')->lower()->plural();
        $this->crud->setRouteNamePrefix($classBasename);
        $this->crud->setTitle(Str::title($classBasename));
    }

    public function config() {
        return $this->crud->toArray();
    }
}
