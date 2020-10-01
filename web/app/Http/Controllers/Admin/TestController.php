<?php

namespace App\Http\Controllers\Admin;

use Lit\Core\Http\Controllers\CoreController;

class TestController extends CoreController
{
    public function setup()
    {
        $this->crud->setColumns([1, 2, 3, 4]);

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

        $this->crud->setColumns([
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
