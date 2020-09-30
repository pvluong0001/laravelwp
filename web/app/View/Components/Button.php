<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
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
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $size;
    /**
     * @var string
     */
    public $type;
    /**
     * @var string|null
     */
    public $link;

    /**
     * Create a new component instance.
     *
     * @param string $text
     * @param string $class
     * @param string $id
     * @param string $size
     * @param string $type
     * @param string $link
     */
    public function __construct(
        string $text,
        string $class,
        string $id = '',
        string $size = '',
        string $type = 'button',
        string $link = ''
    )
    {
        $this->text = $text;
        $this->class = $class;
        $this->id = $id;
        $this->size = $size;
        $this->type = $type;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button');
    }
}
