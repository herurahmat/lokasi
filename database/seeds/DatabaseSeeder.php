<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql_default = base_path('database/sql/17112019.sql');
        DB::unprepared(file_get_contents($sql_default));
    }
}
