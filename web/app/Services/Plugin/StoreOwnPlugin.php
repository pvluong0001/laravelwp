<?php

namespace App\Services\Plugin;

use App\Http\Requests\Admin\Plugin\CreatePluginRequest;
use App\Repositories\ModuleRepository;
use App\Services\Socket;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class StoreOwnPlugin {
    /**
     * @var ModuleRepository
     */
    private $moduleRepository;

    /**
     * StoreOwnPlugin constructor.
     * @param ModuleRepository $moduleRepository
     */
    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }


    public function handle(CreatePluginRequest $createPluginRequest) {
        try {
            if ($createPluginRequest->has('file')) {

                $file = $createPluginRequest->file('file');

                $zipFile = new \ZipArchive;
                $res = $zipFile->open($file->getRealPath());
                if ($res === TRUE) {
                    $hash = Str::random(12);

                    $extractPath = base_path("Modules/{$hash}/");
                    $zipFile->extractTo($extractPath);
                    $zipFile->close();

                    $config = json_decode(file_get_contents($extractPath . 'module.json'), true);
                    $moduleName = $config['name'];

                    rename($extractPath, str_replace("{$hash}/", $moduleName, $extractPath));

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
                }

                return [
                    'status' => true
                ];
            }

            return [
                'status' => false
            ];
        } catch (\Exception $e) {
            logger($e->getMessage());

            return [
                'status' => false
            ];
        }
    }
}
