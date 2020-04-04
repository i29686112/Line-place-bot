<?php

namespace Tests\Unit;

use App\Models\Places;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testModelIsWorking()
    {
        $savedPlace=factory(Places::class)->create();

        echo json_encode($savedPlace);
        $this->assertTrue(is_a($savedPlace,Places::class));
    }

    protected function setUp():void
    {
        parent::setUp();
    }

}
