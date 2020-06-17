<?php


namespace App\Core;

/**
 * Class ActionParse
 * @package Core
 */
class ActionParse extends Parse implements ActionInterface
{
    /**
     * Saves data to csv file
     * @return string
     */
    public function action(): string
    {
        $file = fopen('parser.csv', 'w');

        $header = ['URL', 'IMAGE'];
        fputcsv($file, $header);

        foreach ($this->pagesArray as $key => $value) {

            foreach ($value['images'] as $image) {
                $line = [$key, $image];
                fputcsv($file, $line);
            }

        }

        fclose($file);

        return 'file saved: parser.csv' . PHP_EOL;
    }

}
