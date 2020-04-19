<?php


namespace App\Classes;


class URLParseResult
{
    public $addresses;
    public $placeNames;


    public static function createFromArray($array){

        $URLParseResult = new URLParseResult();

        $addresses=isset($array['addresses']) && count($array['addresses'])>0?$array['addresses']:['foo','boo'];


        foreach ($addresses as $address) {

            if(strlen($address)>20){

                $URLParseResult->addresses[]=mb_substr($address,0,20,"utf-8");

            }

        }

        $placeNames=isset($array['placeNames']) && $array['placeNames']!==""?[$array['placeNames']]:['foo','boo'];


        foreach ($placeNames as $placeName) {

            if(strlen($placeName)>20){

                $URLParseResult->placeNames[]=mb_substr($placeName,0,20,"utf-8");

            }

        }




        return $URLParseResult;
    }
}
