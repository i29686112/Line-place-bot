<?php

namespace Tests\Classes;

use App\Classes\Line;
use App\Models\LineUsers;
use App\Models\Places;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LineTest extends TestCase
{

    use RefreshDatabase;

    public function testGetPlace_invalid_text()
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
                            "text": "not a url"
                        }
                    }
                ],
                "destination": "U2af4bc147ffeafa527797b94457fc2e0"
            }';
        $line=new Line($input);

        $this->assertNull($line->getPlace());

    }

    public function testGetPlace()
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
        $place=$line->getPlace();


        $this->assertTrue(is_a($place, Places::class));

    }


    public function testGetUser_withGet(){

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

        //create
        $line=new Line($input);
        $line->getUser();


        //then create again, it will find exist data.
        $line=new Line($input);
        $user=$line->getUser();


        $this->assertTrue(is_a($user,LineUsers::class));
    }

    public function testGetUser_withCreate(){

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
