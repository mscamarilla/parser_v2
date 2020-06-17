<?php


namespace App\Entity;

use DOMDocument;

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
     * Page constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $html = file_get_contents($url);
        $this->page = new domDocument;
        $internalErrors = libxml_use_internal_errors(true);
        $this->page->loadHTML($html);
        libxml_use_internal_errors($internalErrors);

        $this->url = $url;

    }

}
