<?php

namespace Lit\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lit\Core\Services\DatabaseService;
use Lit\Core\Services\ScaffoldFromDb;

class BuilderController extends Controller
{
    /**
     * @var DatabaseService
     */
    private $databaseService;

    /**
     * BuilderController constructor.
     * @param DatabaseService $databaseService
     */
    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function index() {
        $tables = $this->databaseService->tables();

        return view('builder::index', compact('tables'));
    }

    public function table($tableName) {
        $table = $this->databaseService->getTableWithColumns($tableName);
        $columnsSelect = view('builder::particles.select', [
            'data' => config('core.columnTypes'),
            'name' => 'columns[]'
        ])->render();

        $columnsField = view('builder::particles.select', [
            'data' => config('core.columnFields'),
            'name' => 'fields[]'
        ])->render();

        $requestRulesHtml = collect(explode('|', config('core.requestRules')))
            ->map(function($rule) {
                return '<option value="' .$rule. '">' . $rule . '</option>';
            })
            ->join('');

        return view('builder::table', compact('table', 'columnsSelect', 'columnsField', 'requestRulesHtml'));
    }

    public function store($tableName, Request $request, ScaffoldFromDb $scaffoldFromDb) {
        $scaffoldFromDb->scaffold($tableName, $request);

        flash()->success('Create CRUD success');
        return redirect()->route('builder.index');
    }
}
