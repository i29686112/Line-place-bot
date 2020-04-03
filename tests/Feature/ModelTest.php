<?php

namespace Tests\Unit;

use App\Models\SavedPlaces;
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
        $savedPlace=factory(SavedPlaces::class)->create();

        echo json_encode($savedPlace);
        $this->assertTrue(is_a($savedPlace,SavedPlaces::class));
    }

    protected function setUp():void
    {
        parent::setUp();
    }

}
