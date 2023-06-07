<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialMedia::create([
            'name' => 'GitHub',
            'url' => 'https://github.com/',
            'api_url' => 'https://api.github.com/',
            'icon' => 'github',
            'api_key' => env('GITHUB_API_KEY'),
        ]);
    }
}
