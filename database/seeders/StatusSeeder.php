<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Status::create([
            'name' => 'Completed',
        ]);

        Status::create([
            'name' => 'In Progress',
        ]);

        Status::create([
            'name' => 'Uncompleted',
        ]);*/

        DB::table('statuses')->insert([
            [ 'id' => '1', 'name'=> 'Completed'],
            [ 'id' => '2', 'name'=> 'In Progress'],
            [ 'id' => '3', 'name'=> 'Uncompleted' ],
        ]);

    }
}
