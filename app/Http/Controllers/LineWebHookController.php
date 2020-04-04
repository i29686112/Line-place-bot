<?php

namespace App\Http\Controllers;

use App\Classes\ConversationUtility;
use App\Classes\HtmlParser;
use App\Classes\Line;
use App\Exceptions\SendMessageToUserException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;

class LineWebHookController extends Controller
{
    //

    public function index(Request $request, LINEBot $lineBot){


        $line = new Line(json_encode($request->all()));

        $resultText='';
        //do parse if user send an URL
        if($line->getPlace()->url){

            $htmlParser=new HtmlParser($line->getPlace()->url);

            $parseNames=$htmlParser->getPlaceSuggestNames();
            $parseAddresses=$htmlParser->getPlaceSuggestAddresses();
            $parseCategories=$htmlParser->getPlaceSuggestCategories();


            //check with user...
            $conversation = new ConversationUtility($line);

            try {
                $resultText = 'Check the name of the place, suggest:' . json_encode($parseNames);

                $conversation->setDataForCurrentStep('suggestNames',$parseNames);
                $conversation->setDataForCurrentStep('suggestAddresses',$parseAddresses);
                $conversation->setDataForCurrentStep('suggestCategories',$parseCategories);

                $response=$lineBot->replyText($line->getReplyToken(), $resultText);

                if(!$response->isSucceeded()){ throw new SendMessageToUserException($response->getRawBody());}


            } catch (SendMessageToUserException $e) {

                log::error('\n\n send message to user failed;\n\n ');
                log::error($e->getMessage());

            } catch (\ReflectionException $e) {

                log::error($e->getTraceAsString());

            }

        }


        return $resultText;

    }


}
