<?php


namespace App\Interfaces;

use App\Entity\Page;

/**
 * Interface ItemInterface
 * @package InterfaceNameSpace
 */
interface ItemInterface
{
    /**
     * @param Page $page
     * @return array
     */
    public function getTags(Page $page): array;
}
