<?php

namespace App\Traits;

trait BreadCrumbs
{
    protected function setBreadCrumbs(array $breadcrumbsConfig)
    {
        $breadcrumbs = array_merge(config('global.admin.breadcrumbs'), $breadcrumbsConfig);

        config()->set('global.admin.breadcrumbs', $breadcrumbs);
    }

    protected function disableBreadCrumbs()
    {
        config()->set('global.admin.showBreadcrumbs', false);
    }
}
