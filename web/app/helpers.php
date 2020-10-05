<?php

if (!function_exists('add_menu')) {
    function add_menu($config, $hash)
    {
        $navigation = cache('navigation');

        $data = \Illuminate\Support\Arr::only($config, ['label', 'link', 'child']);
        $data['hash'] = $hash;

        switch ($config['type']) {
            case 'group':
                if (!empty($config['after'])) {
                    $index = array_search(strtolower($config['after']), array_column($navigation, 'label'));

                    array_splice($navigation, ++$index, 0, [$data]);
                } else {
                    $navigation[] = $data;
                }
                break;
        }

        return (bool)app()->make(\App\Services\CommonCache::class)->cacheNavigation($navigation);
    }
}

if (!function_exists('remove_menu_by_hash')) {
    function remove_menu_by_hash($hash, &$navigation) {
        foreach($navigation as $key => &$item) {
            if(!empty($item['child'])) {
                remove_menu_by_hash($hash, $item['child']);
            }

            if(!empty($item['hash']) && $item['hash'] === $hash) {
                unset($navigation[$key]);
            }
        }
    }
}

if(!function_exists('add_role')) {
    function add_role($name) {
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => $name]);
    }
}

if(!function_exists('remove_role')) {
    function remove_role($name) {
        \Spatie\Permission\Models\Role::where('name', $name)->delete();
    }
}