<?php

namespace Lit\Core\Services;

class CrudPanel
{
    private $createView = 'crud::create';
    private $layout = 'crud::layout';
    private $columns = [];
    private $layoutCreateGrid = [
        'grid' => null,
        'template' => null
    ];

    /**
     * @return string
     */
    public function getCreateView(): string
    {
        return $this->createView;
    }

    /**
     * @param string $createView
     */
    public function setCreateView(string $createView): void
    {
        $this->createView = $createView;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @return array
     */
    public function getLayoutCreateGrid()
    {
        return $this->layoutCreateGrid['grid'];
    }

    /**
     * @return string
     */
    public function getLayoutCreateGridTemplate()
    {
        return $this->layoutCreateGrid['template'];
    }

    /**
     * @param null[] $layoutCreateGrid
     */
    public function setLayoutCreateGrid(array $layoutCreateGrid): void
    {
        $this->layoutCreateGrid = $layoutCreateGrid;
    }

    public function transformColumnsInGrid() {
        $this->setColumns(
            collect($this->getColumns())->groupBy('area')->toArray()
        );
    }
}
