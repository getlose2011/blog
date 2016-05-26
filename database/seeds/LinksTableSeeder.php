<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'link_name' => 'facebook',
                'link_title' => 'facebook',
                'link_url' => 'https://www.facebook.com/',
                'link_order' => 1,
            ],
            [
                'link_name' => 'google',
                'link_title' => 'google',
                'link_url' => 'https://www.google.com.tw/',
                'link_order' => 2,
            ],
        ];
        DB::table('links')->insert($data);
    }
}
