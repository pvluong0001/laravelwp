<?php

namespace Lit\Core\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Lit\Core\Entities\Crud;
use Nwidart\Modules\Generators\FileGenerator;

class ScaffoldFromDb
{
    public function scaffold($tableName, Request $request) {
        $createModel = $request->get('create_model');

        $name = (string) Str::of($tableName)->singular()->studly();

        Artisan::call('module:make-crud', ['name' => $name]);

        if($createModel) {
            $model = $this->_createModel($tableName, $name, $request);
        } else {
            $model = $request->get('model');
        }

        /*
         * create CONTROLLER
         */
        $controller = $this->_createController($model, $name, $request);

        /*
         * create ROUTER
         */
        $this->_createRoute($tableName, $name, $controller);

        Crud::create([
            'table_name' => $tableName,
            'config' => $request->all()
        ]);
    }

    private function _createModel($tableName, $name, $request) {
        $fillable = $request->get('fillables');

        $modelNamespace = "Modules\\" . config('global.admin.crudPrefix') . $name . "\Entities";
        $modelStub = app_path('stubs/custom/model-crud.stub');
        $modelPath = base_path("Modules/" .config('global.admin.crudPrefix'). "$name/Entities/$name.php");

        $stubContent = file_get_contents($modelStub);

        $content = Str::of($stubContent)
            ->replace(
                ['$NAMESPACE$', '$CLASS$', '$TABLE$', '$FILLABLE$'],
                [$modelNamespace, $name, $tableName , $this->_convertFillable($fillable)]
            );

        (new FileGenerator($modelPath, $content))->generate();

        return $modelNamespace . "\\" . $name;
    }

    private function _createController($model, $name, Request $request) {
        $controllerNamespace = "Modules\\" . config('global.admin.crudPrefix') . $name . "\Http\Controllers";
        $controllerStub = app_path('stubs/custom/controller-crud.stub');
        $controllerPath = base_path("Modules/" .config('global.admin.crudPrefix'). "{$name}/Http/Controllers/{$name}Controller.php");

        app('files')->makeDirectory(base_path("Modules/" .config('global.admin.crudPrefix'). "{$name}/Http/Controllers"), 0755, true);

        $stubContent = file_get_contents($controllerStub);

        /*
         * create REQUEST
         */
        list($createRequest, $updateRequest) = $this->_createRequest($request, $name);

        $content = Str::of($stubContent)
            ->replace(
                ['$NAMESPACE$', '$CLASS$', '$MODEL$', '$CREATEREQUEST$', '$UPDATEREQUEST$'],
                [$controllerNamespace, $name, $model, $createRequest, $updateRequest]
            );

        (new FileGenerator($controllerPath, $content))->generate();

        return $controllerNamespace . "\\" . $name . 'Controller';
    }

    private function _createRoute($resource, $name, $controller) {
        $routeStub = app_path('stubs/custom/route-crud.stub');
        $routePath = base_path("Modules/" .config('global.admin.crudPrefix'). "{$name}/Routes/web.php");

        $stubContent = file_get_contents($routeStub);

        $content = Str::of($stubContent)
            ->replace(
                ['$RESOURCE$', '$CONTROLLER$'],
                [$resource, $controller]
            );

        (new FileGenerator($routePath, $content))->generate();
    }

    private function _convertFillable(array $fillable) {
        if(empty($fillable)) {
            return '[]';
        }

        return json_encode($fillable);
    }

    private function _createRequest($request, $name) {
        $createRequest = Request::class;
        $updateRequest = Request::class;

        $fieldDefs = $request->get('fieldsDef');
        $createRequests = $request->get('createRequests', []);
        $updateRequests = $request->get('updateRequests', []);

        $requestDef = $request->get('request', []);
        if($requestDef) {
            if(isset($requestDef['create'])) {
                $createRequest = $this->_cloneRequest('create', $name, $fieldDefs, $createRequests);
            }

            if(isset($requestDef['update'])) {
                $updateRequest = $this->_cloneRequest('update', $name, $fieldDefs, $updateRequests);
            }
        }

        return [
            $createRequest,
            $updateRequest
        ];
    }

    private function _cloneRequest($type, $name, $fieldDefs, $validationRules) {
        $type = Str::studly($type);
        $fieldDefs = collect($fieldDefs)->keyBy(null)->map(function($value) use ($validationRules) {
            return $validationRules[$value] ?? ['nullable'];
        });

        $requestNamespace = "Modules\\" . config('global.admin.crudPrefix') . $name . "\Http\Requests";
        $requestStub = app_path('stubs/custom/request-crud.stub');
        $requestPath = base_path("Modules/" .config('global.admin.crudPrefix'). "{$name}/Http/Requests/{$type}{$name}Request.php");

        $ruleString = Str::of($fieldDefs->toJson(JSON_PRETTY_PRINT))
            ->replace(
                ['{', '}', ':'],
                ['[', ']', ' =>']
            );

        $stubContent = file_get_contents($requestStub);

        $content = Str::of($stubContent)
            ->replace(
                ['$NAMESPACE$', '$TYPE$', '$NAME$', '$RULES$'],
                [$requestNamespace, $type , $name, $ruleString]
            );

        (new FileGenerator($requestPath, $content))->generate();

        return $requestNamespace . "\\" . "{$type}{$name}Request";
    }
}
