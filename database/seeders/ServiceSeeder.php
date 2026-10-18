<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'title_ar' => 'خدمة 1',
                'title_en' => 'Service 1',
                'description_ar' => 'وصف الخدمة الأولى...',
                'description_en' => 'Description for service 1...',
            ],
            [
                'title_ar' => 'خدمة 2',
                'title_en' => 'Service 2',
                'description_ar' => 'وصف الخدمة الثانية...',
                'description_en' => 'Description for service 2...',
            ],
            [
                'title_ar' => 'خدمة 3',
                'title_en' => 'Service 3',
                'description_ar' => 'وصف الخدمة الثالثة...',
                'description_en' => 'Description for service 3...',
            ],
            [
                'title_ar' => 'خدمة 4',
                'title_en' => 'Service 4',
                'description_ar' => 'وصف الخدمة الرابعة...',
                'description_en' => 'Description for service 4...',
            ],
        ]);
    }
}
