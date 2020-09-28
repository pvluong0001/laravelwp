<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CommonCache {
    public function cacheNavigation($navigation = null) {
        if(!$navigation) {
            $navigation = json_decode(file_get_contents(config_path('navigation.json')), true);
        }

        Cache::forever('navigation', $navigation);

        Cache::forever('navigationView',
            view('admin.particles.sidebar', [
                'menu' => $navigation
            ])->render()
        );

        return true;
    }
}
