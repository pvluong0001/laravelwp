<?php

namespace Lit\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lit\Core\Services\Traits\ViewPanel;

/**
 * Class CrudPanel
 * @package Lit\Core\Services
 * @property Model $model
 */
class CrudPanel
{
    use ViewPanel;

    private $model;
    private $columns = [];
    private $fields = [];
    private $routeNamePrefix;
    private $title;
    private $searchRequest = '\Lit\Core\Http\Requests\JqueryDataTableRequest';
    private $disableRoute = [];
    private $createRequest = Request::class;
    private $updateRequest = Request::class;
    public $temp;
    private $data;

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

    public function transformFieldsInGrid()
    {
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

    public function setColumnsFromModel(): void
    {
        /** @var Model $model */
        $model = app()->make($this->getModel());
        $fillable = $model->getFillable();
        $hidden = $model->getHidden();

        $this->columns = array_map(function ($field) {
            return [
                'type' => 'text',
                'data' => $field,
                'title' => Str::title($field)
            ];
        }, array_values(array_diff($fillable, $hidden)));
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getSearchRequest(): string
    {
        return $this->searchRequest;
    }

    /**
     * @param string $searchRequest
     */
    public function setSearchRequest(string $searchRequest): void
    {
        $this->searchRequest = $searchRequest;
    }

    /**
     * @return array
     */
    public function getDisableRoute(): array
    {
        return $this->disableRoute;
    }

    /**
     * @param array $disableRoute
     */
    public function setDisableRoute(array $disableRoute): void
    {
        $this->disableRoute = $disableRoute;
    }

    /**
     * @param string $route
     * @return bool
     */
    public function cannotAccessRoute(string $route): bool
    {
        return in_array($route, $this->disableRoute);
    }

    /**
     * @return string
     */
    public function getCreateRequest(): string
    {
        return $this->createRequest;
    }

    /**
     * @param string $createRequest
     */
    public function setCreateRequest(string $createRequest): void
    {
        $this->createRequest = $createRequest;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = collect($data);
    }

    /**
     * @return string
     */
    public function getUpdateRequest(): string
    {
        return $this->updateRequest;
    }

    /**
     * @param string $updateRequest
     */
    public function setUpdateRequest(string $updateRequest): void
    {
        $this->updateRequest = $updateRequest;
    }
}
