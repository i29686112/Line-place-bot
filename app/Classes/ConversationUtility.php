<?php


namespace App\Classes;


use App\models\Conversations;
use App\Models\Places;

class ConversationUtility
{
    /** @var Conversations */
    public $currentConversation;

    /**
     * ConversationUtility constructor.
     * @param Line $line
     */
    public function __construct(Line $line)
    {

        $this->currentConversation = Conversations::where(['type'=>'url','status' => 'open', 'user_id' => $line->userId])
            ->orderBy('id','desc')
            ->first();

        if(isset($line->getPlace()->url) && $this->currentConversation)
        {
            $this->closeExistConversation();
            $this->createNewConversation($line);
        }

        if(!$this->currentConversation){

            $this->createNewConversation($line);

        }


    }

    public function getNoteObjectFromCurrentConversation():Note
    {


        if ($this->currentConversation) {

            return Note::createFromArray(json_decode($this->currentConversation->note,true));


        }

        return null;

    }


    public function toNextStep()
    {

        if ($this->currentConversation) {
            //close exist
            $this->currentConversation->step = $this->currentConversation->step+1;
            return $this->currentConversation->save();
        }

        return false;

    }



    private function closeExistConversation()
    {

        //close exist
        $this->currentConversation->status = 'closed';
        return $this->currentConversation->save();

    }

    public function setDataForCurrentStep(string $key, $parseNames)
    {

        $currentNote = json_decode($this->currentConversation->note);

        $currentNote->{$key}=$parseNames;

        $this->currentConversation->note= json_encode($currentNote);

        $this->currentConversation->save();


    }

    /**
     * @param Line $line
     */
    private function createNewConversation(Line $line): void
    {
        $this->currentConversation = Conversations::create(
            ['type' => 'url', 'status' => 'open', 'user_id' => $line->userId, 'note' => '{}']
        );
    }

    public function saveConversationResultAndClose()
    {

        $note=$this->getNoteObjectFromCurrentConversation();

        $place=Places::where(['add_user_id'=>$this->currentConversation->user_id,'url'=>$note->currentURL])->first();

        $place->name=$note->choosePlaceName;
        $place->address=$note->choosePlaceAddress;

        $place->category_name=$note->choosePlaceCategory;

        $place->save();

        $this->closeExistConversation();



    }

}
