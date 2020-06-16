<?php
/*a - action
  u - url
  d - depth
*/
$options = getopt('a:u:d::');

//composer Vendor loading
require_once('vendor/autoload.php');

use Core\ActionDefinition;

try{
    ActionDefinition::load($options);
} catch (Throwable $error){
    echo 'Error occurs! ' . $error->getMessage() . PHP_EOL;
}
