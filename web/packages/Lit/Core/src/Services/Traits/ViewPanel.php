<?php
namespace Lit\Core\Services\Traits;

trait ViewPanel
{
    private $createView = 'crud::create';
    private $indexView = 'crud::index';
    private $editView = 'crud::edit';
    private $listView = 'crud::list';
    private $layout = 'crud::layout';
    private $assets = 'jquery';
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

    /**
     * @return string
     */
    public function getIndexView(): string
    {
        return $this->indexView;
    }

    /**
     * @param string $indexView
     */
    public function setIndexView(string $indexView): void
    {
        $this->indexView = $indexView;
    }

    /**
     * @return null
     */
    public function getAssets()
    {
        return 'list_' . $this->assets;
    }

    /**
     * @param null $assets
     */
    public function setAssets($assets): void
    {
        $this->assets = $assets;
    }

    /**
     * @return string
     */
    public function getListView(): string
    {
        return $this->listView;
    }

    /**
     * @param string $listView
     */
    public function setListView(string $listView): void
    {
        $this->listView = $listView;
    }

    /**
     * @return string
     */
    public function getEditView(): string
    {
        return $this->editView;
    }

    /**
     * @param string $editView
     */
    public function setEditView(string $editView): void
    {
        $this->editView = $editView;
    }
}
