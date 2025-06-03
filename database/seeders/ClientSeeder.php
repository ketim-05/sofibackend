<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Hope Music Ethiopia',
                'logo_url' => '/HopeLogo.png',
                'website_url' => 'https://hopemusicethiopia.com',
                'description' => 'Leading music distribution and promotion company in Ethiopia.',
                'is_active' => true
            ],
            [
                'name' => 'Balageru Records',
                'logo_url' => '/Balageru.png',
                'website_url' => 'https://balagerurecords.com',
                'description' => 'Prominent Ethiopian record label specializing in traditional and contemporary music.',
                'is_active' => true
            ],
            [
                'name' => 'Fana Television',
                'logo_url' => '/FanaTv.png',
                'website_url' => 'https://fanatv.com',
                'description' => 'Major Ethiopian television network and media company.',
                'is_active' => true
            ],
            [
                'name' => 'Sewasew Magazine',
                'logo_url' => '/Sewasew.png',
                'website_url' => 'https://sewasew.com',
                'description' => 'Popular Ethiopian lifestyle and entertainment magazine.',
                'is_active' => true
            ],
            [
                'name' => 'Ethiopian Broadcasting Corporation',
                'logo_url' => '/ebc-logo.png',
                'website_url' => 'https://ebc.et',
                'description' => 'National public broadcaster of Ethiopia.',
                'is_active' => true
            ],
            [
                'name' => 'Addis Music',
                'logo_url' => '/addis-music.png',
                'website_url' => 'https://addismusic.com',
                'description' => 'Independent music label focusing on emerging Ethiopian artists.',
                'is_active' => true
            ]
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }
    }
}
