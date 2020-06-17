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

}
