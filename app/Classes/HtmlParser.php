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


        $jsonData= exec(env('PY_BIN_PATH','python'). "  ".env('PY_FILE_PATH'). " '".$this->url."'");


        return $jsonData;


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
