<?php


namespace App\Classes;


use App\Classes\Exceptions\NotURLStringException;
use App\Models\LineUsers;
use App\Models\Places;

class Line
{

    /** @var Places */
    private $place;
    private $rawInput;
    private $jsonObject;

    /** @var LineUsers */
    private $user;
    private $replyToken;
    public $userId;

    /**
     * Line constructor.
     * @param $webHookResponse
     */
    public function __construct($webHookResponse)
    {

        $this->rawInput=$webHookResponse;
        $this->jsonObject=json_decode($webHookResponse);

        $this->setReplyToken();

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

            if($this->getURLFromInput()===false) throw new NotURLStringException();

            if($existPlace = Places::where(['add_user_id'=>$this->user->line_id,'url'=>$this->getURLFromInput()])->first()){

                return $existPlace;
            }

            $newPlace = new Places();

            $newPlace->url = $this->getURLFromInput();

            $newPlace->add_user_id = $this->user->line_id;

            $newPlace->save();

            return $newPlace;

        }catch(NotURLStringException $e){

            return null;
        }


    }

    /**
     * @return mixed
     */
    private function getURLFromInput()
    {
        return filter_var($this->jsonObject->events[0]->message->text,FILTER_VALIDATE_URL);
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
