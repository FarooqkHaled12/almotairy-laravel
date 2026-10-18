<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hero_section')->insert([
            'title_ar' => 'مرحباً بك في',
            'title_en' => 'Welcome to',
            'highlight_word_1_ar' => 'المطيري',
            'highlight_word_1_en' => 'Almotairy',
            'subtitle_ar' => 'نحن نقدم أفضل',
            'subtitle_en' => 'We provide the best',
            'highlight_word_2_ar' => 'الخدمات',
            'highlight_word_2_en' => 'Services',
            'description_ar' => 'نحن نقدم حلول مبتكرة وخدمات متميزة لعملائنا في جميع أنحاء المملكة. فريقنا من الخبراء جاهز لمساعدتك في تحقيق أهدافك وتطوير أعمالك.',
            'description_en' => 'We provide innovative solutions and excellent services to our clients throughout the Kingdom. Our team of experts is ready to help you achieve your goals and grow your business.',
            'button_1_title_ar' => 'ابدأ الآن',
            'button_1_title_en' => 'Get Started',
            'button_1_link' => '#services',
            'button_2_title_ar' => 'تواصل معنا',
            'button_2_title_en' => 'Contact Us',
            'button_2_link' => '#contact',
            'stat_1_number' => '500+',
            'stat_1_title_ar' => 'عميل سعيد',
            'stat_1_title_en' => 'Happy Clients',
            'stat_2_number' => '1000+',
            'stat_2_title_ar' => 'مشروع مكتمل',
            'stat_2_title_en' => 'Completed Projects',
            'stat_3_number' => '15+',
            'stat_3_title_ar' => 'سنوات خبرة',
            'stat_3_title_en' => 'Years Experience',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
