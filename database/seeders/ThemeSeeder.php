<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        Theme::insert([
            ['name' => 'default', 'label' => 'Default Theme', 'preview_image' => '/themes/default/preview.png'],
            ['name' => 'modern', 'label' => 'Modern Theme', 'preview_image' => '/themes/modern/preview.png'],
            ['name' => 'dark', 'label' => 'Dark Theme', 'preview_image' => '/themes/dark/preview.png'],
        ]);
    }

}
