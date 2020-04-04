<?php


namespace App\Classes;


use App\Exceptions\NotURLStringException;
use App\Models\LineUsers;
use App\Models\Places;

class Line
{

    /** @var Places */
    private $place;

    public $inputRawText;
    public $userId;



    private $inputHttpText;
    private $jsonObject;

    /** @var LineUsers */
    private $user;
    private $replyToken;

    /**
     * Line constructor.
     * @param $webHookResponse
     */
    public function __construct($webHookResponse)
    {

        $this->inputHttpText=$webHookResponse;
        $this->jsonObject=json_decode($webHookResponse);

        $this->setReplyToken();
        $this->setInputRawText();

        $this->setUser();
        $this->setPlace();

    }

    public function getPlace()
    {

        return $this->place;
    }

    private function setPlace()
    {


        $this->place= ($this->findOrSavePlace())?:null;


    }

    public function getUser()
    {
        return $this->user;

    }

    private function setUser()
    {

        $this->user= $this->findOrSaveUser();

        $this->userId=$this->user->line_id;

    }

    /**
     * @return LineUsers|bool
     */
    private function findOrSaveUser()
    {

        return $flight = LineUsers::firstOrCreate(
            ['line_id' => $this->getUserId()],
            ['line_id' => $this->getUserId()]
        );
    }

    /**
     * @return mixed
     */
    private function getUserId()
    {
        return $this->jsonObject->events[0]->source->userId;
    }

    private function findOrSavePlace()
    {

        try{

            if(filter_var($this->inputRawText,FILTER_VALIDATE_URL)===false) throw new NotURLStringException();

            if($existPlace = Places::where(['add_user_id'=>$this->user->line_id,'url'=>$this->inputRawText])->first()){

                return $existPlace;
            }

            $newPlace = new Places();

            $newPlace->url = $this->inputRawText;

            $newPlace->add_user_id = $this->user->line_id;

            $newPlace->save();

            return $newPlace;

        }catch(NotURLStringException $e){

            return null;
        }


    }


    public function getInputRawText()
    {
        return $this->inputRawText;
    }

    private function setInputRawText()
    {
        $this->inputRawText=$this->jsonObject->events[0]->message->text;
    }

    private function setReplyToken()
    {
        $this->replyToken= $this->jsonObject->events[0]->replyToken;

    }

    public function getReplyToken()
    {
        return $this->replyToken;

    }
}
