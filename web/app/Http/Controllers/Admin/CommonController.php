<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Plugin\CreatePluginRequest;
use App\Repositories\ModuleRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CommonController extends Controller
{
    public function dashboard()
    {
        return view('admin.pages.dashboard');
    }

    public function menu()
    {
        $this->setBreadCrumbs([
            [
                'label' => 'Settings'
            ]
        ]);

        return view('admin.pages.menu');
    }
}
