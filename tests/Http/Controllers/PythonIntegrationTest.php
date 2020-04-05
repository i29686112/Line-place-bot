<?php

namespace Tests\Http\Controllers;

use App\Classes\ConversationUtility;
use App\Classes\DisplayText;
use App\Classes\Line;
use App\Http\Controllers\LineWebHookController;
use App\models\Conversations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PythonIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function testGetURLTitleByPython_OK()
    {

        //create a conversation with URL text
        $response=$this->get('/pyTest?url=https://blog.gtwang.org/programming/python-beautiful-soup-module-scrape-web-pages-tutorial/');
        $response->assertStatus(200);

        $this->assertNotFalse(stripos($response->getContent(),"</title>"));

    }

}
