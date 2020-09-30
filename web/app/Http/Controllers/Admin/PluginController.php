<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Module;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Plugin\CreatePluginRequest;
use App\Repositories\ModuleRepository;
use App\Services\Plugin\ActivePlugin;
use App\Services\Plugin\RemovePlugin;
use App\Services\Plugin\StoreOwnPlugin;
use App\Services\Socket;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    /**
     * @var ModuleRepository
     */
    private $moduleRepository;
    /**
     * @var Socket
     */
    private $socket;

    /**
     * PluginController constructor.
     * @param ModuleRepository $moduleRepository
     * @param Socket $socket
     */
    public function __construct(ModuleRepository $moduleRepository, Socket $socket)
    {

        $this->moduleRepository = $moduleRepository;
        $this->socket = $socket;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $modules = $this->moduleRepository->paginate(10);

        return view('admin.pages.plugins.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $this->setBreadCrumbs([
            [
                'label' => 'Plugins'
            ]
        ]);

        $modules = $this->moduleRepository->paginate(10);

        return view('admin.pages.plugins.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePluginRequest $createPluginRequest
     * @param StoreOwnPlugin $storeOwnPlugin
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePluginRequest $createPluginRequest, StoreOwnPlugin $storeOwnPlugin)
    {
        return response()->json($storeOwnPlugin->handle($createPluginRequest));
    }

    public function active(Module $module, ActivePlugin $activePlugin) {
        $activePlugin->handle($module);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param RemovePlugin $removePlugin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id, RemovePlugin $removePlugin)
    {
        $removePlugin->handle($this->moduleRepository->find($id));

        return redirect()->back();
    }
}
