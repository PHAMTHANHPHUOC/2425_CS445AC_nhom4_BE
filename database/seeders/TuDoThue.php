<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TuDoThue extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tu_dos')->delete();

        DB::table('tu_dos')->truncate();

        DB::table('tu_dos')->insert([
            
        ]);
    }
}
