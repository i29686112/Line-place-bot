<?php


namespace App\Classes;


use App\models\Conversations;

class ConversationUtility
{
    /** @var Conversations */
    private $currentConversation;

    /**
     * ConversationUtility constructor.
     * @param Line $line
     */
    public function __construct(Line $line)
    {

        if ($line->getPlace()->url) {
            //open a new conversation
            $this->currentConversation = Conversations::where(['type'=>'url','status' => 'open', 'user_id' => $line->userId])->first();
            $this->closeExist();
        }

        $this->currentConversation = Conversations::create(
            ['type'=>'url','status' => 'open', 'user_id' => $line->userId,'note'=>'{}']
        );

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



    public function closeExist()
    {

        if ($this->currentConversation) {
            //close exist
            $this->currentConversation->status = 'closed';
            return $this->currentConversation->save();
        }

        return false;
    }

    public function setDataForCurrentStep(string $key, array $parseNames)
    {

        $currentNote = json_decode($this->currentConversation->note);

        $currentNote->{$key}=$parseNames;

        $this->currentConversation->note= json_encode($currentNote);

        $this->currentConversation->save();


    }

}
