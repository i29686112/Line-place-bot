<?php

namespace App\Http\Controllers;

use App\Classes\ConversationUtility;
use App\Classes\HtmlParser;
use App\Classes\Line;
use App\Exceptions\SendMessageToUserException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use ReflectionException;

class LineWebHookController extends Controller
{
    //

    public function index(Request $request, LINEBot $lineBot){


        if (!$request->all()) return 'empty input';


        $line = new Line(json_encode($request->all()));

        $resultText='';

        if($line->getPlace()){
            $resultText = $this->newPlaceStoreConversation($lineBot, $line);

        }else{

            $conversationUtility = new ConversationUtility($line);

            switch($conversationUtility->currentConversation->step){

                case 0:
                    $conversationUtility->setDataForCurrentStep('choosePlaceName',$line->inputRawText);
                    $conversationUtility->toNextStep();

                    $resultText="You set the name:{$line->inputRawText}\n";
                    $resultText.= "let's set the address of the place, suggest:" . json_encode($conversationUtility->getNoteObjectFromCurrentConversation()->suggestAddresses);
                    $this->sendTextToLineUser($lineBot, $line, $resultText);

                    break;

                case 1:
                    $conversationUtility->setDataForCurrentStep('choosePlaceAddress',$line->inputRawText);
                    $conversationUtility->toNextStep();

                    $resultText="You set the address:{$line->inputRawText}\n";
                    $resultText.= "let's set the category of the place, suggest:" . json_encode($conversationUtility->getNoteObjectFromCurrentConversation()->suggestCategories);
                    $this->sendTextToLineUser($lineBot, $line, $resultText);

                    break;

                case 2:
                    $conversationUtility->setDataForCurrentStep('choosePlaceCategory',$line->inputRawText);
                    $conversationUtility->toNextStep();

                    $resultText="You set the category:{$line->inputRawText}\n\n";


                    $note=$conversationUtility->getNoteObjectFromCurrentConversation();

                    $resultText.="Your input about url:{$note->currentURL}\n\n";
                    $resultText.= "Name:{$note->choosePlaceName}\n";
                    $resultText.= "Address:{$note->choosePlaceAddress}\n";
                    $resultText.= "Category:{$note->choosePlaceCategory}\n\n";
                    $resultText.="type `edit` to update, or type any word to submit";

                    $this->sendTextToLineUser($lineBot, $line, $resultText);

                    break;

                case 3:

                    if($line->inputRawText!=='edit'){

                        $conversationUtility->saveConversationResultAndClose();
                        $resultText="Saved!";
                        $this->sendTextToLineUser($lineBot, $line, $resultText);

                    }else{

                        $conversationUtility->restartStep();

                        //update again
                        $note=$conversationUtility->getNoteObjectFromCurrentConversation();
                        $resultText="Ok, let us start again!\n\n";

                        $resultText .= 'Check the name of the place, suggest:' . json_encode($note->suggestAddresses);
                        $this->sendTextToLineUser($lineBot, $line, $resultText);
                    }

                    break;
            }

        }


        return $resultText;

    }

    /**
     * @param LINEBot $lineBot
     * @param Line $line
     * @return string
     */
    private function newPlaceStoreConversation(LINEBot $lineBot, Line $line): string
    {

        //do parse if user send an URL
        $htmlParser = new HtmlParser($line->getPlace()->url);

        $parseNames = $htmlParser->getPlaceSuggestNames();
        $parseAddresses = $htmlParser->getPlaceSuggestAddresses();
        $parseCategories = $htmlParser->getPlaceSuggestCategories();


        //check with user...
        $conversation = new ConversationUtility($line);


        $conversation->setDataForCurrentStep('currentURL', $line->getPlace()->url);
        $conversation->setDataForCurrentStep('suggestNames', $parseNames);

        $conversation->setDataForCurrentStep('suggestAddresses', $parseAddresses);
        $conversation->setDataForCurrentStep('suggestCategories', $parseCategories);


        $resultText = 'Check the name of the place, suggest:' . json_encode($parseNames);
        $this->sendTextToLineUser($lineBot, $line, $resultText);


        return $resultText;
    }

    /**
     * @param LINEBot $lineBot
     * @param Line $line
     * @param string $resultText
     * @return bool
     */
    private function sendTextToLineUser(LINEBot $lineBot, Line $line, string $resultText): bool
    {

        try {

            $response = $lineBot->replyText($line->getReplyToken(), $resultText);

            if (!$response->isSucceeded()) {
                throw new SendMessageToUserException($response->getRawBody());
            }

            return true;

        } catch (SendMessageToUserException $e) {

            log::error('\n\n send message to user failed;\n\n ');
            log::error($e->getMessage());

            return false;
        } catch (ReflectionException $e){
            log::error($e->getMessage());

            return false;
        }

    }


}
