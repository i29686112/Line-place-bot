<?php

use App\Models\Places;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        foreach ([1,2,3] as $category_id) {
            factory(Places::class)->create(['category_id'=>$category_id]);

        }

    }
}
