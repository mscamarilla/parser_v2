<?php


namespace App\Core;


use App\Entity\Hrefs;
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
        $hrefs = new Hrefs();
        $page->setTags($hrefs);

        $page->setTags($tags);

        $path = explode('\\', get_class($tags));
        $tagName = strtolower(array_pop($path));

        $this->pagesArray[$page->url][$tagName] = $page->tags[$tagName];

        if (!empty($page->tags['hrefs'])) {

            $i = 0;
            foreach ($page->tags['hrefs'] as $key => $href) {
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
