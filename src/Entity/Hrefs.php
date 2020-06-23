<?php


namespace App\Entity;

use App\Core\ActionDefinition;
use App\Interfaces\ItemInterface;


/**
 * Class Hrefs
 * @package Entity
 */
class Hrefs implements ItemInterface
{

    /**
     * @var string
     */
    private $tagName;

    /**
     * Hrefs constructor.
     */
    public function __construct()
    {
        $this->setTagName();
    }

    /**
     * Gets all links on the page
     * @param Page $page
     * @return array
     */
    public function getTags(Page $page): array
    {

        $raw_links = [];
        $links = [];

        $tags = $page->page->getElementsByTagName('a');

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
        return $links;

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
     * Set tag name
     */
    public function setTagName(): void
    {
        $path = explode('\\', get_class($this));
        $tagName = strtolower(array_pop($path));

        $this->tagName = $tagName;
    }

}
