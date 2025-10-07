<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'locale' => 'en_US',
                'direction' => 'ltr',
                'status' => true,
            ],
            [
                'name' => 'Hindi',
                'code' => 'hi',
                'locale' => 'hi_IN',
                'direction' => 'ltr',
                'status' => true,
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}
