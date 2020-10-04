<?php

namespace Lit\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class CrudPanel
 * @package Lit\Core\Services
 * @property Model $model
 */
class CrudPanel
{
    private $createView = 'crud::create';
    private $indexView = 'crud::index';
    private $listView = 'crud::list';
    private $layout = 'crud::layout';
    private $model;
    private $columns = [];
    private $fields = [];
    private $assets = null;
    private $layoutCreateGrid = [
        'grid' => null,
        'template' => null
    ];
    private $routeNamePrefix;
    private $title;

    /**
     * @return string
     */
    public function getCreateView(): string
    {
        return $this->createView;
    }

    /**
     * @param string $createView
     */
    public function setCreateView(string $createView): void
    {
        $this->createView = $createView;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @return array
     */
    public function getLayoutCreateGrid()
    {
        return $this->layoutCreateGrid['grid'];
    }

    /**
     * @return string
     */
    public function getLayoutCreateGridTemplate()
    {
        return $this->layoutCreateGrid['template'];
    }

    /**
     * @param null[] $layoutCreateGrid
     */
    public function setLayoutCreateGrid(array $layoutCreateGrid): void
    {
        $this->layoutCreateGrid = $layoutCreateGrid;
    }

    public function transformFieldsInGrid() {
        $this->setFields(
            collect($this->getFields())->groupBy('area')->toArray()
        );
    }

    /**
     * @return mixed
     */
    public function getRouteNamePrefix()
    {
        return $this->routeNamePrefix;
    }

    /**
     * @param mixed $routeNamePrefix
     */
    public function setRouteNamePrefix($routeNamePrefix): void
    {
        $this->routeNamePrefix = 'crud.' . $routeNamePrefix;
    }

    /**
     * @return string
     */
    public function getIndexView(): string
    {
        return $this->indexView;
    }

    /**
     * @param string $indexView
     */
    public function setIndexView(string $indexView): void
    {
        $this->indexView = $indexView;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = Str::title($title);
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function setColumnsFromModel(): void {
        $this->columns = array_map(function($field) {
            return [
                'type' => 'text',
                'name' => $field
            ];
        }, app()->make($this->getModel())->getFillable());
    }

    public function toArray() {
        return get_object_vars($this);
    }

    /**
     * @return null
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param null $assets
     */
    public function setAssets($assets): void
    {
        $this->assets = $assets;
    }

    /**
     * @return string
     */
    public function getListView(): string
    {
        return $this->listView;
    }

    /**
     * @param string $listView
     */
    public function setListView(string $listView): void
    {
        $this->listView = $listView;
    }
}
