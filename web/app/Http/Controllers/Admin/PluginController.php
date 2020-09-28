<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Plugin\CreatePluginRequest;
use App\Repositories\ModuleRepository;
use App\Services\Socket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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
     * @param ModuleRepository $moduleRepository
     */
    public function store(CreatePluginRequest $createPluginRequest, ModuleRepository $moduleRepository)
    {
        $socket = $this->socket->open('isocket', 1357);
        $connection = $createPluginRequest->get('connection');

        try {
            if ($createPluginRequest->has('file')) {
                $this->socket->write($socket, json_encode(
                    ['type' => 'message', 'text' => 'Prepare extracting.....', 'connection' => $connection]
                ));

                $file = $createPluginRequest->file('file');

                $zipFile = new \ZipArchive;
                $res = $zipFile->open($file->getRealPath());
                if ($res === TRUE) {
                    $hash = Str::random(12);

                    $extractPath = base_path("Modules/{$hash}/");
                    $zipFile->extractTo($extractPath);
                    $zipFile->close();

                    $this->socket->write($socket, json_encode(
                        ['type' => 'message', 'text' => 'Extracting success!', 'connection' => $connection]
                    ));

                    $config = json_decode(file_get_contents($extractPath . 'module.json'), true);
                    $moduleName = $config['name'];

                    rename($extractPath, str_replace("{$hash}/", $moduleName, $extractPath));

                    sleep(10);

                    $this->socket->write($socket, json_encode(
                        ['type' => 'message', 'text' => 'Installing.....', 'connection' => $connection]
                    ));
                    Artisan::call('module:update ' . $moduleName);

                    logger('1');

                    $moduleRepository->create([
                        'name'   => $moduleName,
                        'config' => $config
                    ]);

                    logger('2');


                    if(!empty($config['menu'])) {
                        foreach($config['menu'] as $item) {
                            add_menu($item);
                        }
                    }

                    logger('3');


                    $this->socket->write($socket, json_encode(
                        ['type' => 'message', 'text' => 'Install success!', 'connection' => $connection]
                    ));

                    logger('done');
                } else {
                    $this->socket->write($socket, json_encode(
                        ['type' => 'message', 'text' => 'Extracting failed!', 'connection' => $connection]
                    ));
                }

                logger('close');
                $this->socket->close($socket);

                return response()->json([
                    'status' => true
                ]);
            }

            return response()->json([
                'status' => false
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());

            if($socket) {
                $this->socket->close($socket);
            }
        }

        return redirect()->route('');
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
