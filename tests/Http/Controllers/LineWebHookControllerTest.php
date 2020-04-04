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

        $conversation = Conversations::where(['type'=>'url','status' => 'open', 'user_id' => $testLineId])->first();

        $note=json_decode($conversation->note);

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
