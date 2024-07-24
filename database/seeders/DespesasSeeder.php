<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Despesa;

class DespesasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Despesa::factory()->count(5)->create();
    }
}
