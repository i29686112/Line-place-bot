<?php

use App\Models\SavedPlaces;
use Illuminate\Database\Seeder;

class SavedPlaceSeeder extends Seeder
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
            factory(SavedPlaces::class)->create(['category_id'=>$category_id]);

        }

    }
}
