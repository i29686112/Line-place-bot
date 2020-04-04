<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\LineWebHookController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LineWebHookControllerTest extends TestCase
{
    use RefreshDatabase;

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
