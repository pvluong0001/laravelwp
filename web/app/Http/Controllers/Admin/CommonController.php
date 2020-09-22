<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Plugin\CreatePluginRequest;
use App\Repositories\ModuleRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CommonController extends Controller
{
    public function dashboard() {
        return view('admin.pages.dashboard');
    }

    public function menu() {
        $this->setBreadCrumbs([
            [
                'label' => 'Settings'
            ]
        ]);

        return view('admin.pages.menu');
    }

    public function plugins() {
        $this->setBreadCrumbs([
            [
                'label' => 'Plugins'
            ]
        ]);

        return view('admin.pages.plugins');
    }

    public function createPlugin(CreatePluginRequest $createPluginRequest, ModuleRepository $moduleRepository) {
        try {
            if($createPluginRequest->has('file')) {
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

                    $moduleRepository->create([
                        ''
                    ]);
                }
            }
        } catch(\Exception $e) {

        }

        return redirect()->back();
    }
}
