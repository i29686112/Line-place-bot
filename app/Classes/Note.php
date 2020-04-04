<?php


namespace App\Classes;


class Note
{

    public $currentURL;

    public $suggestName;
    public $suggestCategories;
    public $suggestAddresses;

    public $choosePlaceAddress;
    public $choosePlaceCategory;
    public $choosePlaceName;

    public static function createFromArray($dataArray)
    {
        $note=new self();


        foreach ($dataArray as $field=>$value) {

            $note->{$field}=$value;
        }


        return $note;

    }
}
