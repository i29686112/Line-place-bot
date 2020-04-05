<?php


namespace App\Classes;


use GuzzleHttp\Client;

class HtmlParser
{
    private $url;

    /**
     * HtmlParser constructor.
     * @param mixed $url
     */
    public function __construct($url)
    {
        $this->url=$url;
    }

    public function getPlaceSuggestNamesFromPython()
    {

        //$response = (new Client())->request('get',env("PLACE_NAME_PARSE_URL")."?url=". $this->url);

        $jsondata= exec("/usr/bin/python  ".env('PY_FILE_PATH'). " 'https://www.tutorialspoint.com/python/python_command_line_arguments.htm'");


        //return json_decode($response->getBody(),true);


        return $jsondata;


    }


    public function getPlaceSuggestNames()
    {

        $response = (new Client())->request('get',env("PLACE_NAME_PARSE_URL")."?url=". $this->url);

        return json_decode($response->getBody(),true);

    }


    public function getPlaceSuggestCategories()
    {

        $response = (new Client())->request('get',env("CATEGORY_PARSE_URL")."?url=". $this->url);

        return json_decode($response->getBody(),true);
        //return ['category','foo','boo'];

    }

    public function getPlaceSuggestAddresses()
    {

        $response = (new Client())->request('get',env("ADDRESS_PARSE_URL")."?url=". $this->url);

        return json_decode($response->getBody(),true);

        //return ['address','foo','boo'];

    }
}
