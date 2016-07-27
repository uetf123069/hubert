<?php

use Illuminate\Database\Seeder;

class SettingsAddEmailLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'key' => 'mail_logo',
		    'value' => ''
        ]);
    }
}
