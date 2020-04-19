<?php


namespace App\Classes;


use GuzzleHttp\Client;

class HtmlParser
{
    private $url;

    /**
     * @var URLParseResult
     */
    private $urlParseResult;

    /**
     * HtmlParser constructor.
     * @param mixed $url
     */
    public function __construct($url)
    {
        $this->url=$url;

        $this->generateJsonData();
    }

    public function getPlaceSuggestNamesFromPython()
    {

        return  $this->urlParseResult;


    }


    public function getPlaceSuggestNames()
    {

        //$response = (new Client())->request('get',env("PLACE_NAME_PARSE_URL")."?url=". $this->url);

        //return json_decode($response->getBody(),true);

        return  $this->urlParseResult->placeNames;


    }


    public function getPlaceSuggestCategories()
    {

        $response = (new Client())->request('get',env("CATEGORY_PARSE_URL")."?url=". $this->url);

        return json_decode($response->getBody(),true);
        //return ['category','foo','boo'];

    }

    public function getPlaceSuggestAddresses()
    {

        //$response = (new Client())->request('get',env("ADDRESS_PARSE_URL")."?url=". $this->url);

        return  $this->urlParseResult->addresses;

        //return ['address','foo','boo'];

    }

    private function generateJsonData(): void
    {
        $urlParseResult = exec(env('PY_BIN_PATH', 'python') . "  " . env('PY_FILE_PATH') . " '" . $this->url . "'");

        $urlParseResult = str_replace("'", "\"", $urlParseResult);

        $urlParseResult = json_decode($urlParseResult, true);

        $this->urlParseResult=URLParseResult::createFromArray($urlParseResult);


    }
}
