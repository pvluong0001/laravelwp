<?php

namespace Lit\Core\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Lit\Core\Services\CrudPanel;

class QBuilder
{
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var CrudPanel
     */
    private $crudPanel;

    /**
     * QBuilder constructor.
     * @param Builder $builder
     * @param CrudPanel $crudPanel
     */
    public function __construct(Builder $builder, CrudPanel $crudPanel)
    {
        $this->builder = $builder;
        $this->crudPanel = $crudPanel;
    }

    /**
     * @return CrudPanel
     */
    public function getCrudPanel(): CrudPanel
    {
        return $this->crudPanel;
    }

    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }
}
