<?php


namespace App\Core;


use App\Entity\Hrefs;
use App\Entity\Images;
use App\Entity\Page;

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
     * @param int $depth
     */
    public function __construct(Page $page, int $depth)
    {
        $this->depth = $depth;
        $this->pagesArray = [];
        $this->parse($page);
    }

    /**
     * Parse all pages and create new Entities
     * @param Page $page
     */
    protected function parse(Page $page): void
    {
        $images = new Images();
        $page->setTags($images);

        $hrefs = new Hrefs();
        $page->setTags($hrefs);

        $this->pagesArray[$page->url]['images'] = $page->tags['images'];

        if (!empty($page->tags['hrefs'])) {

            $i = 0;
            foreach ($page->tags['hrefs'] as $key => $href) {
                $innerPage = new Page($href);
                $innerPageImages = new Images();
                $innerPage->setTags($innerPageImages);

                if (!empty($innerPage->tags['images'])) {
                    $this->pagesArray[$innerPage->url]['images'] = $innerPage->tags['images'];
                }

                $i++;

                if ($i >= $this->depth) {
                    break;
                }
            }
        }
    }

}
