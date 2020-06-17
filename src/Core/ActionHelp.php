<?php


namespace App\Core;

use App\Interfaces\ActionInterface;

/**
 * Class ActionHelp
 * @package Core
 */
class ActionHelp implements ActionInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * ActionHelp constructor.
     */
    public function __construct()
    {
        include('src/Lang/Help.php');
        $this->text = $help_text;
    }

    /** Displays help text in command line
     * @return string
     */
    public function action(): string
    {
        return $this->getText();
    }

    /**
     * Gets $text
     * @return mixed
     */
    private function getText(): string
    {
        return $this->text;
    }

}