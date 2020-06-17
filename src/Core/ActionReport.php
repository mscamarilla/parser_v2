<?php


namespace App\Core;

use App\Interfaces\ActionInterface;

/**
 * Class ActionReport
 * @package Core
 */
class ActionReport extends Parse implements ActionInterface
{
    /**
     * Displays data in command line
     * @return string
     */
    public function action(): string
    {
        $output = '';
        foreach ($this->pagesArray as $key => $value) {

            foreach ($value['images'] as $image) {
                $output .= $key . ' ';
                $output .= $image . ';' . "\n";
            }

        }

        return $output;
    }
}
