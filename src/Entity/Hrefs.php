<?php


namespace Entity;

use Core\ActionDefinition;
use InterfaceNameSpace\ItemInterface;


/**
 * Class Hrefs
 * @package Entity
 */
class Hrefs implements ItemInterface
{
    /**
     * @var Page
     */
    public $page;
    /**
     * @var array
     */
    public $hrefs;

    /**
     * Hrefs constructor.
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->getTags();
    }

    /**
     * Gets all links on the page
     * @return array
     */
    public function getTags(): array
    {

        $raw_links = [];
        $links = [];

        $tags = $this->page->page->getElementsByTagName('a');

        foreach ($tags as $tag) {
            $raw_links[] = $tag->getAttribute('href');
        }

        foreach ($raw_links as $link) {
            $link = parse_url($link);
            //if domain is missing or equals constant - it's inner page
            if (empty($link['host']) || ActionDefinition::isDomainInner($link['host'])) {
                //if path is missing - it's link to the main page
                $link_path = ActionDefinition::convertUrl(!empty($link['path']) ? $link['path'] : DOMAIN);

                if (ActionDefinition::isUrlAvailable($link_path)) {
                    $links[$link_path] = $link_path;

                }
            }
        }
        return $this->hrefs = $links;

    }

}
