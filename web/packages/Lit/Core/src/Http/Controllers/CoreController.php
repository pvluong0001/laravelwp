<?php

namespace Lit\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Lit\Core\Http\Controllers\Traits\ListCrud;
use Lit\Core\Http\Controllers\Traits\SearchCrud;
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
    use ListCrud, SearchCrud;

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

    public function create() {
        if(method_exists($this, 'setupCreateUpdate')) {
            $this->setupCreateUpdate();
        }

        if(method_exists($this, 'setupCreate')) {
            $this->setupCreate();
        }

        if($this->crud->getLayoutCreateGrid()) {
            $this->crud->transformFieldsInGrid();
        }

        if(in_array('create', $this->crud->getDisableRoute())) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        return view($this->crud->getCreateView(), $this->data);
    }

    public function store() {
        if(method_exists($this, 'setupCreate')) {
            $this->setupCreate();
        }

        /** @var Request $request */
        $request = app()->make($this->crud->getCreateRequest());

        dd($request->validated());
    }

    public function edit() {
        if(method_exists($this, 'setupCreateUpdate')) {
            $this->setupCreateUpdate();
        }
    }

    public function config() {
        return $this->crud->toArray();
    }
}
