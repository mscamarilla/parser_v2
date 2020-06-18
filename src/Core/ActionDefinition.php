<?php

namespace App\Core;


use App\Entity\Page;
use Exception;

/**
 * Class ActionDefinition
 * @package Core
 */
class ActionDefinition
{
    /**
     * Loads correct action entity
     * @param array $options
     * @throws Exception
     */
    static function load(array $options): void
    {
        if (empty($options) || $options['a'] === 'help') {
            $action = new ActionHelp();

        } else {

            if (!class_exists('App\Core\Action' . ucfirst($options['a']))) {
                throw new Exception('Class App\Core\Action\\' . ucfirst($options['a']) . ' not found!');
            }

            if (empty($options['u'])) {
                throw new Exception('Option -u is required! Use "-a help" for details');
            }

            $action_name = 'App\Core\Action' . ucfirst($options['a']);

            $cleanUrl = self::cleanUrl($options['u']);
            //defines domain and scheme for the first time to use them on inner pages
            self::defineGlobals($cleanUrl);
            //Add correct scheme and domain to bring the link to a single view
            $url = self::convertUrl($options['u']);

            if (!empty($options['d'])) {
                $depth = $options['d'];
            } else {
                $depth = 5;
            }

            //t - tag to parse
            if (!empty($options['t'])) {
                $tag = $options['t'];
                if (!class_exists('App\Entity\\' . ucfirst($tag))) {
                    throw new Exception('Class App\Entity\\' . ucfirst($tag) . ' not found!');
                }
                $tagClassName = 'App\Entity\\' . $tag;
            } else {
                $tag = 'Images';
                $tagClassName = 'App\Entity\\' . $tag;
            }
            $tags = new $tagClassName();

            $page = new Page($url);
            $action = new $action_name($page, $tags, $depth);


        }

        echo $action->action();
    }

    /**
     * Cleans url from scheme and domain
     * @param string $url
     * @return string
     */
    static function cleanUrl(string $url): string
    {
        //remove www and all specified protocols. Protocol will be redefined
        $url = str_replace('www.', '', $url);
        $url = str_replace('http://', '', $url);
        $url = str_replace('https://', '', $url);

        return $url;

    }

    /**
     * Converts a link to a single format
     * @param string $url
     * @return string
     */
    static function convertUrl(string $url): string
    {
        //add constant DOMAIN
        if (!stristr($url, DOMAIN)) {
            if ($url[0] !== '/') {
                $url = DOMAIN . '/' . $url;
            } else {
                $url = DOMAIN . $url;
            }

        }

        //add constant SCHEME
        if (!stristr($url, SCHEME)) {
            $url = SCHEME . $url;
        }

        return $url;

    }

    /**
     * Defines DOMAIN and SCHEME
     * @param string $url
     * @throws Exception
     */
    static function defineGlobals(string $url): void
    {
        $httpsCheck = self::isUrlAvailable('https://' . $url);

        if ($httpsCheck) {
            define('SCHEME', 'https://');
        } else {
            $httpCheck = self::isUrlAvailable('http://' . $url);

            if ($httpCheck) {
                define('SCHEME', 'http://');
            } else {
                throw new Exception('URL is unreachable!');
            }
        }

        //define DOMAIN
        $domain = parse_url(SCHEME . $url, PHP_URL_HOST);

        define('DOMAIN', $domain);
    }

    /**
     * Checks if url is reachable
     * source: https://www.codexworld.com/how-to/check-website-availability-php-curl/
     * @param string $url
     * @return bool
     */
    static function isUrlAvailable(string $url): bool
    {
        $getUrl = @file_get_contents($url);

        if (!filter_var($url, FILTER_VALIDATE_URL) || !$getUrl) {
            return false;
        }

        return true;
    }

    /**
     * Checks if domain is inner
     * @param string $domain
     * @return bool
     */
    static function isDomainInner(string $domain): bool
    {
        // cut off www and scheme in domain
        $domain = str_replace(SCHEME, '', str_replace('www.', '', $domain));
        //if cropped domain is equal constant DOMAIN - it's inner page
        if ($domain === DOMAIN) {
            return true;
        }

        return false;
    }

}
