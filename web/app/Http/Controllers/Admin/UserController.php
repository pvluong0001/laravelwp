<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\DB;
use Lit\Core\Http\Controllers\CoreController;

class UserController extends CoreController
{
    public function setup()
    {
        $this->crud->setModel(User::class);
        $this->crud->setLayout('layouts.admin');
        $this->crud->setColumnsFromModel();

        dd(DB::connection('mysql')->getDoctrineSchemaManager());

        $this->crud->setLayoutCreateGrid([
            'grid'     => [
                'area1' => [
                    'title' => 'Area 1'
                ],
                'area2' => [
                    'title' => 'Area 2'
                ],
                'area3' => [
                    'title' => 'Area 3'
                ]
            ],
            'template' => '
                \'area1 area1 area2\'
                \'area1 area1 area3\'
            '
        ]);

        $this->crud->setFields([
            [
                'name'  => 'Test',
                'label' => 'Something',
                'area'  => 'area1'
            ],
            [
                'name'  => 'Test',
                'label' => 'Something',
                'area'  => 'area2'
            ],
            [
                'name'  => 'Test',
                'label' => 'Something',
                'area'  => 'area1'
            ],
            [
                'name'  => 'Test',
                'label' => 'Something',
                'area'  => 'area3'
            ],
            [
                'name'  => 'Test',
                'label' => 'Something',
                'area'  => 'area3'
            ],
            [
                'name'  => 'Test',
                'label' => 'Something',
                'area'  => 'area1'
            ],
        ]);
    }
}
