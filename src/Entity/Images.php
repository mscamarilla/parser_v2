<?php


namespace Entity;


use InterfaceNameSpace\ItemInterface;


/**
 * Class Images
 * @package Entity
 */
class Images implements ItemInterface
{
    /**
     * @var Page
     */
    public $page;
    /**
     * @var array
     */
    public $images;

    /**
     * Images constructor.
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->getTags();

    }

    /**
     * Gets all image on the page
     * @return array
     */
    public function getTags(): array
    {
        $images = [];

        $tags = $this->page->page->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $images[] = $tag->getAttribute('src');
        }

        return $this->images = $images;

    }

}
