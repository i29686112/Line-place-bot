<?php


namespace App\Classes;


use App\Models\LineUsers;

class Line
{

    private $url;
    private $rawInput;
    private $jsonObject;

    /** @var LineUsers */
    private $user;

    /**
     * Line constructor.
     * @param $webHookResponse
     */
    public function __construct($webHookResponse)
    {

        $this->rawInput=$webHookResponse;
        $this->jsonObject=json_decode($webHookResponse);

        $this->setURL();

        $this->setUser();


    }

    public function getURL()
    {

        return $this->url;
    }

    private function setURL()
    {

        $this->url=$this->jsonObject->events[0]->message->text;

    }

    public function getUser()
    {
        return $this->user;

    }

    private function setUser()
    {

        $this->user= $this->findOrSaveUser();


    }

    /**
     * @return LineUsers|bool
     */
    private function findOrSaveUser()
    {
        $lineUser = new LineUsers();

        $lineUser->line_id = $this->getUserId();

        $lineUser->save();

        return $lineUser;
    }

    /**
     * @return mixed
     */
    private function getUserId()
    {
        return $this->jsonObject->events[0]->source->userId;
    }
}
