<?php

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        foreach ( ['食','住','玩'] as $name) {
            factory(Categories::class)->create(['name'=>$name]);

        }

    }
}
