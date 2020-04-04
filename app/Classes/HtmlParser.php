<?php


namespace App\Classes;


class HtmlParser
{

    /**
     * HtmlParser constructor.
     * @param mixed $url
     */
    public function __construct($url)
    {
    }

    public function getPlaceSuggestNames()
    {
        return ['name','foo','boo'];

    }


    public function getPlaceSuggestCategories()
    {
        return ['category','foo','boo'];

    }

    public function getPlaceSuggestAddresses()
    {
        return ['address','foo','boo'];

    }
}
