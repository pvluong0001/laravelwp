<?php

namespace App\Services\Plugin;

use App\Entities\Module;
use App\Services\CommonCache;
use Illuminate\Support\Facades\Artisan;

class RemovePlugin {
    /**
     * @var CommonCache
     */
    private $commonCache;

    /**
     * RemovePlugin constructor.
     * @param CommonCache $commonCache
     */
    public function __construct(CommonCache $commonCache)
    {
        $this->commonCache = $commonCache;
    }

    public function handle(Module $module) {
        Artisan::call('module:migrate-rollback ' . $module->name);

        if($module->activated) {
            $navigation = cache('navigation');
            remove_menu_by_hash($module->hash, $navigation);

            $this->commonCache->cacheNavigation($navigation);
        }

        $module->delete();

        flash()->success('Remove plugin success!');
    }
}
