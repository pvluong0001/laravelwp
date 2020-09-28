<?php

if(!function_exists('add_menu')) {
    function add_menu($config) {
        $navigation = cache('navigation');

        $data = \Illuminate\Support\Arr::only($config, ['label', 'link', 'child']);

        logger($data);

        switch ($config['type']) {
            case 'group':
                if(!empty($config['after'])) {
                    $index = array_search(strtolower($config['after']), array_column($navigation, 'label'));

                    array_splice($navigation, ++$index, 0, [$data]);
                } else {
                    $navigation[] = $data;
                }
                break;
        }

        logger($navigation);

        return (bool) app()->make(\App\Services\CommonCache::class)->cacheNavigation($navigation);
    }
}
