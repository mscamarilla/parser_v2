<?php


namespace App\Core;

use App\Entity\Page;
use App\Interfaces\ItemInterface;

/**
 * Class Parse
 * @package Core
 */
class Parse
{
    /**
     * @var int
     */
    protected $depth;
    /**
     * @var array
     */
    protected $pagesArray;

    /**
     * Parse constructor.
     * @param Page $page
     * @param ItemInterface $tags
     * @param int $depth
     */
    public function __construct(Page $page, ItemInterface $tags, int $depth)
    {
        $this->depth = $depth;
        $this->pagesArray = [];
        $this->parse($page, $tags);
    }

    /**
     * Parse all pages and create new Entities
     * @param Page $page
     * @param ItemInterface $tags
     */
    protected function parse(Page $page, ItemInterface $tags): void
    {
        $page->setTags($tags);
        $tagName = $tags->getTagName();

        $this->pagesArray[$page->url][$tagName] = $page->tags[$tagName];

        if (!empty($page->innerPages)) {

            $i = 0;
            foreach ($page->innerPages as $key => $href) {
                $innerPage = new Page($href);
                $innerPageImages = $tags;
                $innerPage->setTags($innerPageImages);

                if (!empty($innerPage->tags[$tagName])) {
                    $this->pagesArray[$innerPage->url][$tagName] = $innerPage->tags[$tagName];
                }

                $i++;

                if ($i >= $this->depth) {
                    break;
                }
            }
        }
    }

}
