<?php


namespace App\Entity;


use App\Interfaces\ItemInterface;


/**
 * Class Images
 * @package Entity
 */
class Images implements ItemInterface
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * Images constructor.
     */
    public function __construct()
    {
        $this->setTagName();
    }

    /**
     * Gets all image on the page
     * @param Page $page
     * @return array
     */
    public function getTags(Page $page): array
    {
        $images = [];

        $tags = $page->page->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $images[] = $tag->getAttribute('src');
        }

        return $images;

    }

    /**
     * Get tag name
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }


    /**
     * Set tag  name
     */
    public function setTagName(): void
    {
        $path = explode('\\', get_class($this));
        $tagName = strtolower(array_pop($path));

        $this->tagName = $tagName;
    }


}
