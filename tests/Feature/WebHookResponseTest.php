<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebHookResponseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {


        $urlResponse='{
                        "events": [
                            {
                                "type": "message",
                                "replyToken": "3af54478fa5a41af8e883dc6291c57b9",
                                "source": {
                                    "userId": "Ua9e76b328979298d4205a2faf1df550c",
                                    "type": "user"
                                },
                                "timestamp": 1585903735532,
                                "mode": "active",
                                "message": {
                                    "type": "text",
                                    "id": "11717635525998",
                                    "text": "https://keketravel.cc/2988/?from=instant_article"
                                }
                            }
                        ],
                        "destination": "U2af4bc147ffeafa527797b94457fc2e0"
                    }';

        $webHookConfirmResponse='
        {
            "events": [
                {
                    "replyToken": "00000000000000000000000000000000",
                    "type": "message",
                    "timestamp": 1585901991124,
                    "source": {
                        "type": "user",
                        "userId": "Udeadbeefdeadbeefdeadbeefdeadbeef"
                    },
                    "message": {
                        "id": "100001",
                        "type": "text",
                        "text": "Hello, world"
                    }
                },
                {
                    "replyToken": "ffffffffffffffffffffffffffffffff",
                    "type": "message",
                    "timestamp": 1585901991124,
                    "source": {
                        "type": "user",
                        "userId": "Udeadbeefdeadbeefdeadbeefdeadbeef"
                    },
                    "message": {
                        "id": "100002",
                        "type": "sticker",
                        "packageId": "1",
                        "stickerId": "1"
                    }
                }
            ]
        }';
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
