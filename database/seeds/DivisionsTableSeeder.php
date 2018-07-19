<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('divisions')->insert
        ([
            [
                'name' => 'Division 1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Division 2',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Division 3',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
