<?php

namespace Database\Seeders;

use App\Models\Pastel;
use Illuminate\Database\Seeder;

class PastelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pastel::factory(15)->create();
    }
}
