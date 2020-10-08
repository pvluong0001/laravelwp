<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestRequest;
use App\User;
use Lit\Core\Http\Controllers\CoreController;

class UserController extends CoreController
{
    public function setup()
    {
        $this->crud->setModel(User::class);
        $this->crud->setLayout('layouts.admin');
        $this->crud->setColumnsFromModel();
    }

    public function setupCreateUpdate()
    {
        $this->crud->setFields([
            [
                'name' => 'name',
                'type' => 'text'
            ],
            [
                'name' => 'email',
                'type' => 'email'
            ]
        ]);
    }

    public function setupCreate() {
        $this->crud->setCreateRequest(TestRequest::class);
//        $this->crud->setLayoutCreateGrid([
//            'grid'     => [
//                'area1' => [
//                    'title' => 'Area 1'
//                ],
//                'area2' => [
//                    'title' => 'Area 2'
//                ],
//                'area3' => [
//                    'title' => 'Area 3'
//                ]
//            ],
//            'template' => '
//                \'area1 area1 area2\'
//                \'area1 area1 area3\'
//            '
//        ]);

//        $this->crud->setFields([
//            [
//                'name'  => 'Test',
//                'label' => 'Something',
//                'area'  => 'area1'
//            ],
//            [
//                'name'  => 'Test',
//                'label' => 'Something',
//                'area'  => 'area2'
//            ],
//            [
//                'name'  => 'Test',
//                'label' => 'Something',
//                'area'  => 'area1'
//            ],
//            [
//                'name'  => 'Test',
//                'label' => 'Something',
//                'area'  => 'area3'
//            ],
//            [
//                'name'  => 'Test',
//                'label' => 'Something',
//                'area'  => 'area3'
//            ],
//            [
//                'name'  => 'Test',
//                'label' => 'Something',
//                'area'  => 'area1'
//            ],
//        ]);
    }
}
