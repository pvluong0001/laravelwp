<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tag extends Component
{
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $class;

    /**
     * Create a new component instance.
     *
     * @param string $text
     * @param string $class
     */
    public function __construct(string $text, string $class = 'white')
    {

        $this->text = $text;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.tag');
    }
}
