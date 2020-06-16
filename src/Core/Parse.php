<?php


namespace Core;


use Entity\Hrefs;
use Entity\Images;
use Entity\Page;

/**
 * Class Parse
 * @package Core
 */
class Parse
{
    /**
     * @var string
     */
    protected $pageUrl;
    /**
     * @var Images
     */
    protected $images;
    /**
     * @var Hrefs
     */
    protected $hrefs;
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
        $this->pageUrl = $page->url;
        $this->images = new Images($page);
        $this->hrefs = new Hrefs($page);
        $this->depth = $depth;
        $this->pagesArray = [];
        $this->parse();
    }

    /**
     * Parse all pages and create new Entities
     */
    protected function parse(): void
    {
        $this->pagesArray[$this->pageUrl]['images'] = $this->images->images;

        if (!empty($this->hrefs->hrefs)) {

            $i = 0;
            foreach ($this->hrefs->hrefs as $key => $href) {
                $innerPageEntity = new Page($href);

                $innerPageImageEntity = new Images($innerPageEntity);

                if (!empty($innerPageImageEntity->images)) {
                    $this->pagesArray[$innerPageEntity->url]['images'] = $innerPageImageEntity->images;
                }

                $i++;

                if ($i >= $this->depth) {
                    break;
                }
            }
        }
    }

}
