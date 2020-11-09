<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
          ['key' => 'theme', 'value' => 'default'],
          ['key' => 'sms_api_id', 'value' => 'A45AB883-F0B7-D8E7-AAEB-EFEE909C4150'],
          ['key' => 'sms_api_phone', 'value' => '7(977)445-5738']
        ]

        );
    }
}
