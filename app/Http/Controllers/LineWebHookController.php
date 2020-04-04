<?php

namespace App\Http\Controllers;

use App\Classes\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;

class LineWebHookController extends Controller
{
    //

    public function index(Request $request, LINEBot $lineBot){



        $line = new Line(json_encode($request->all()));

        //do parse...

        try {
            $lineBot->replyText($line->getReplyToken(),$line->getPlace()->url);
        } catch (\ReflectionException $e) {

            log::error($e->getTraceAsString());

        }


        return '';
    }
}
