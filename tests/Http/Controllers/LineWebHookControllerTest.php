<?php

namespace Tests\Http\Controllers;

use App\Classes\ConversationUtility;
use App\Classes\Line;
use App\Http\Controllers\LineWebHookController;
use App\models\Conversations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LineWebHookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex_step3toEnd_EDIT_restart_again()
    {

        $testLineId = "Ua9e76b328979298d4205a2faf1df550c";

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "'.$testLineId.'",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';


        //create a conversation with URL text
        $response=$this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);


        //answer desired place name
        $input2=str_replace("https://keketravel.cc/2988/?from=instant_article","desire place name",$input);
        $response = $this->json('post','/', json_decode($input2,true));
        $response->assertStatus(200);


        //answer desired address
        $input3=str_replace("https://keketravel.cc/2988/?from=instant_article","desire address",$input);
        $response = $this->json('post','/', json_decode($input3,true));
        $response->assertStatus(200);


        //answer desired address
        $input4=str_replace("https://keketravel.cc/2988/?from=instant_article","desire category",$input);
        $response = $this->json('post','/', json_decode($input4,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'You set the category') !== false);


        //answer desired address
        $input5=str_replace("https://keketravel.cc/2988/?from=instant_article","edit",$input);
        $response = $this->json('post','/', json_decode($input5,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'Ok, let us start again') !== false);



    }


    public function testIndex_step3toEnd_SAVED_confirm_user_input()
    {

        $testLineId = "Ua9e76b328979298d4205a2faf1df550c";

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "'.$testLineId.'",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';


        //create a conversation with URL text
        $response=$this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);


        //answer desired place name
        $input2=str_replace("https://keketravel.cc/2988/?from=instant_article","desire place name",$input);
        $response = $this->json('post','/', json_decode($input2,true));
        $response->assertStatus(200);


        //answer desired address
        $input3=str_replace("https://keketravel.cc/2988/?from=instant_article","desire address",$input);
        $response = $this->json('post','/', json_decode($input3,true));
        $response->assertStatus(200);


        //answer desired address
        $input4=str_replace("https://keketravel.cc/2988/?from=instant_article","desire category",$input);
        $response = $this->json('post','/', json_decode($input4,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'You set the category') !== false);


        //answer desired address
        $input5=str_replace("https://keketravel.cc/2988/?from=instant_article","ok",$input);
        $response = $this->json('post','/', json_decode($input5,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'Saved') !== false);



    }


    public function testIndex_step2to3_confirm_category_with_user()
    {

        $testLineId = "Ua9e76b328979298d4205a2faf1df550c";

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "'.$testLineId.'",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';


        //create a conversation with URL text
        $response=$this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);


        //answer desired place name
        $input2=str_replace("https://keketravel.cc/2988/?from=instant_article","desire place name",$input);
        $response = $this->json('post','/', json_decode($input2,true));
        $response->assertStatus(200);


        //answer desired address
        $input3=str_replace("https://keketravel.cc/2988/?from=instant_article","desire address",$input);
        $response = $this->json('post','/', json_decode($input3,true));
        $response->assertStatus(200);


        //answer desired address
        $input3=str_replace("https://keketravel.cc/2988/?from=instant_article","desire category",$input);
        $response = $this->json('post','/', json_decode($input3,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'You set the category') !== false);


        $conversation = Conversations::where(['type'=>'url','status' => 'open', 'user_id' => $testLineId])->first();

        $note=json_decode($conversation->note);

        $this->assertTrue(isset($note->choosePlaceCategory));

    }


    public function testIndex_step1to2_confirm_address_with_user()
    {

        $testLineId = "Ua9e76b328979298d4205a2faf1df550c";

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "'.$testLineId.'",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';


        //create a conversation with URL text
        $response=$this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);


        //answer desired place name
        $input2=str_replace("https://keketravel.cc/2988/?from=instant_article","desire place name",$input);
        $response = $this->json('post','/', json_decode($input2,true));
        $response->assertStatus(200);


        //answer desired address
        $input3=str_replace("https://keketravel.cc/2988/?from=instant_article","desire address name",$input);
        $response = $this->json('post','/', json_decode($input3,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'You set the address') !== false);


        $conversation = Conversations::where(['type'=>'url','status' => 'open', 'user_id' => $testLineId])->first();

        $note=json_decode($conversation->note);

        $this->assertTrue(isset($note->choosePlaceAddress));

    }

    public function testIndex_step0to1_confirm_name_with_user()
    {

        $testLineId = "Ua9e76b328979298d4205a2faf1df550c";

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "'.$testLineId.'",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';


        //create a conversation with URL text
        $response=$this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);


        //answer desired place name
        $input=str_replace("https://keketravel.cc/2988/?from=instant_article","desire place name",$input);
        $response = $this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'You set the name') !== false);


        $conversation = Conversations::where(['type'=>'url','status' => 'open', 'user_id' => $testLineId])->first();

        $note=json_decode($conversation->note);

        $this->assertTrue(isset($note->choosePlaceName));


    }



    public function testIndex_sendURL_checkConversationNoteIsSaved()
    {

        $testLineId = "Ua9e76b328979298d4205a2faf1df550c";

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "'.$testLineId.'",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';



        //it should close exist conversation
        $response = $this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);
        $this->assertTrue(stripos($response->getContent(),'Check the name of the place') !== false);


        $conversation = Conversations::where(['type'=>'url','status' => 'open', 'user_id' => $testLineId])->first();

        $note=json_decode($conversation->note);

        $this->assertTrue(isset($note->currentURL));
        $this->assertTrue(isset($note->suggestNames));
        $this->assertTrue(isset($note->suggestAddresses));
        $this->assertTrue(isset($note->suggestCategories));

    }


    public function testIndex_sendURLAndStartAConversation()
    {

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "Ua9e76b328979298d4205a2faf1df550c",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';



        //it should close exist conversation
        $response = $this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);

        $this->assertTrue(stripos($response->getContent(),'Check the name of the place') !== false);

    }

    public function testIndex_haveCloseExistConversation()
    {

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "Ua9e76b328979298d4205a2faf1df550c",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';

        //create a conversation
        $line = new Line($input);
        new ConversationUtility($line);



        //it should close exist conversation
        $response = $this->json('post','/', json_decode($input,true));
        $response->assertStatus(200);


        $lastClosedConversation=Conversations::where(['type'=>'url','status' => 'closed', 'user_id' => $line->userId])->first();
        $this->assertTrue(is_a($lastClosedConversation,Conversations::class));


    }

    public function testIndex_sendURL()
    {

        $input = '{
                    "events": [
                        {
                            "type": "message",
                            "replyToken": "d61a0fe4f9c34c81b3b9da59fb15f139",
                            "source": {
                            "userId": "Ua9e76b328979298d4205a2faf1df550c",
                                "type": "user"
                            },
                            "timestamp": 1585971844257,
                            "mode": "active",
                            "message": {
                            "type": "text",
                                "id": "11722243413835",
                                "text": "https://keketravel.cc/2988/?from=instant_article"
                            }
                        }
                    ],
                    "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                }';

        $response = $this->json('post','/', json_decode($input,true));

        $response->assertStatus(200);

    }
}
