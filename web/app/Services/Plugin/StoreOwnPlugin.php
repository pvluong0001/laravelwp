<?php

namespace App\Services\Plugin;

use App\Http\Requests\Admin\Plugin\CreatePluginRequest;
use App\Repositories\ModuleRepository;
use App\Services\Socket;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class StoreOwnPlugin {
    /**
     * @var Socket
     */
    private $socket;
    /**
     * @var ModuleRepository
     */
    private $moduleRepository;

    /**
     * StoreOwnPlugin constructor.
     * @param Socket $socket
     * @param ModuleRepository $moduleRepository
     */
    public function __construct(Socket $socket, ModuleRepository $moduleRepository)
    {
        $this->socket = $socket;
        $this->moduleRepository = $moduleRepository;
    }


    public function handle(CreatePluginRequest $createPluginRequest) {
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

                    $this->socket->write($socket, json_encode(
                        ['type' => 'message', 'text' => 'Installing.....', 'connection' => $connection]
                    ));
                    Artisan::call('module:update ' . $moduleName);

                    $this->moduleRepository->create([
                        'name'   => $moduleName,
                        'config' => $config
                    ]);

//                    if(!empty($config['menu'])) {
//                        foreach($config['menu'] as $item) {
//                            add_menu($item);
//                        }
//                    }

                    $this->socket->write($socket, json_encode(
                        ['type' => 'message', 'text' => 'Install success!', 'connection' => $connection]
                    ));
                } else {
                    $this->socket->write($socket, json_encode(
                        ['type' => 'message', 'text' => 'Extracting failed!', 'connection' => $connection]
                    ));
                }

                $this->socket->close($socket);

                return [
                    'status' => true
                ];
            }

            return [
                'status' => false
            ];
        } catch (\Exception $e) {
            logger($e->getMessage());

            if($socket) {
                $this->socket->close($socket);
            }

            return [
                'status' => false
            ];
        }
    }
}
