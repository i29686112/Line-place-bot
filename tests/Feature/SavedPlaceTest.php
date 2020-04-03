<?php

namespace Tests\Unit;

use App\Classes\Line;
use App\Models\LineUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SavedPlace extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUrlFromUserLineInput()
    {

        $input='{
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
        $line=new Line($input);
        $url=$line->getURL();


        $this->assertIsString(filter_var($url, FILTER_VALIDATE_URL));
    }


    public function testGetUserFromUserLineInput()
    {

        $input='{
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
        $line=new Line($input);
        $user=$line->getUser();

        $this->assertTrue(is_a($user,LineUsers::class));
    }

}
