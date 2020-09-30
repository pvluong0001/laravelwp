<?php

namespace App\Services\Plugin;

use App\Entities\Module;
use App\Services\CommonCache;
use Illuminate\Support\Facades\Artisan;

class ActivePlugin {
    /**
     * @var CommonCache
     */
    private $commonCache;

    /**
     * ActivePlugin constructor.
     * @param CommonCache $commonCache
     */
    public function __construct(CommonCache $commonCache)
    {
        $this->commonCache = $commonCache;
    }

    public function handle(Module $module) {
        if($module->activated) {
            return $this->deactivate($module);
        }

        return $this->activate($module);
    }

    private function deactivate(Module $module) {
        $hash = $module->hash;
        $navigation = cache('navigation');
        remove_menu_by_hash($hash, $navigation);

        $this->commonCache->cacheNavigation($navigation);

        $module->activated = false;
        $module->save();

        flash()->success('Deactivate plugin success!');
        return true;
    }

    private function activate(Module $module) {
        /** @var array $config */
        $config = $module->config;

        if(!empty($config['menu'])) {
            foreach($config['menu'] as $item) {
                add_menu($item, $module->hash);
            }
        }

        Artisan::call('module:migrate ' . $module->name);

        flash()->success('Active plugin success!');
        $module->activated = true;
        $module->save();
        return true;
    }
}
