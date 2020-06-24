<?php


namespace App\Entity;

use App\Core\Parse;
use DOMDocument;
use App\Interfaces\ItemInterface;

/**
 * Class Page
 * @package Entity
 */
class Page
{

    /**
     * @var string
     */
    public $url;
    /**
     * @var DOMDocument
     */
    public $page;

    /**
     * @var array
     */
    public $innerPages;
    /**
     * @var
     */
    public $tags;

    /**
     * Page constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $html = file_get_contents($url);
        $this->page = new domDocument();
        $internalErrors = libxml_use_internal_errors(true);
        $this->page->loadHTML($html);
        libxml_use_internal_errors($internalErrors);

        $this->url = $url;
        $this->setInnerPages();

    }

    /**
     * Set InnerPages
     */
    public function setInnerPages(): void
    {
        $hrefs = new Hrefs();
        $innerPages = new Parse($this, $hrefs,0);
        $this->innerPages = $innerPages->pagesArray[$this->url][$hrefs->getTagName()];
    }


    /**
     * Sets tags
     * @param ItemInterface $obj
     */
    public function setTags(ItemInterface $obj)
    {
        $class = $obj->getTagName();

        $this->tags[$class] = $obj->getTags($this);
    }

}
