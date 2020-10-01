<?php

namespace Lit\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Lit\Core\Services\CrudPanel;

/**
 * Class CoreController
 * @package Lit\Core\Http\Controllers
 * @method void setup Setup for crud
 * @property CrudPanel $crud
 */
class CoreController extends Controller
{
    protected $crud;
    protected $data = [];

    public function __construct()
    {
        $this->crud = app()->make(CrudPanel::class);
        $this->setup();

        if($this->crud->getLayoutCreateGrid()) {
            $this->crud->transformColumnsInGrid();
        }
    }

    public function index() {
        return 'working';
    }

    public function create() {
        $this->data['crud'] = $this->crud;

        return view($this->crud->getCreateView(), $this->data);
    }
}
