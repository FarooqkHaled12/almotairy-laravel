<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PropertyCategory;
use App\Models\Property;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. About Section
        if (DB::table('about_section')->count() == 0) {
            DB::table('about_section')->insert([
                'title_1_ar' => 'من نحن',
                'title_1_en' => 'About Us',
                'title_2_ar' => 'ريادة وتميز في الاستثمار والتسويق العقاري',
                'title_2_en' => 'Leadership and Excellence in Real Estate',
                'description_ar' => 'نقدم حلولاً عقارية متكاملة وخدمات استشارية واستثمارية على أعلى مستويات الاحترافية والمصداقية لتلبية تطلعات عملائنا في امتلاك وحداتهم المثالية أو تحقيق أعلى عوائد استثمارية.',
                'description_en' => 'We provide comprehensive real estate solutions, advisory, and investment services with the highest levels of professionalism to help our clients achieve their goals.',
                'features_ar' => json_encode(['خبرة تفوق 15 عاماً في السوق العقاري', 'فريق استشاري وقانوني متخصص', 'أفضل العروض الحصرية والفرص الاستثمارية']),
                'features_en' => json_encode(['Over 15 years of market experience', 'Specialized advisory and legal team', 'Exclusive deals and investment opportunities']),
                'signature_ar' => 'خالد المطيري - المؤسس والمدير التنفيذي',
                'signature_en' => 'Khalid Almotairy - Founder & CEO',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Contact Info
        if (DB::table('contact_info')->count() == 0) {
            DB::table('contact_info')->insert([
                'phone' => '+966500000000',
                'whatsapp' => '966500000000',
                'email' => 'info@almotairy.org',
                'address_ar' => 'المملكة العربية السعودية - الرياض',
                'address_en' => 'Riyadh, Kingdom of Saudi Arabia',
                'facebook' => 'https://facebook.com',
                'instagram' => 'https://instagram.com',
                'youtube' => 'https://youtube.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Property Categories
        $cat1 = PropertyCategory::firstOrCreate(
            ['name_ar' => 'فلل وقصور'],
            ['name_en' => 'Villas & Mansions']
        );
        $cat2 = PropertyCategory::firstOrCreate(
            ['name_ar' => 'شقق فاخرة'],
            ['name_en' => 'Luxury Apartments']
        );
        $cat3 = PropertyCategory::firstOrCreate(
            ['name_ar' => 'عقارات تجارية'],
            ['name_en' => 'Commercial Properties']
        );

        // 4. Properties
        if (Property::count() == 0) {
            Property::create([
                'category_id' => $cat1->id,
                'name_ar' => 'فيلا مودرن فاخرة بحي النرجس',
                'name_en' => 'Luxury Modern Villa in Al-Narjis',
                'area_ar' => '450 م²',
                'area_en' => '450 sqm',
                'description_ar' => 'فيلا بتصميم عصري راقٍ، تحتوي على مسبح خاص وحديقة واسعة وتشطيبات فندقية فائقة الجودة.',
                'description_en' => 'Contemporary villa with private pool, spacious landscaped garden, and premium ultra-luxury finishing.',
                'features_ar' => ['5 غرف نوم ماستر', 'مسبح خاص', 'مصعد راكب', 'تكييف مركزي', 'موقف لسيارتين'],
                'features_en' => ['5 Master Bedrooms', 'Private Pool', 'Installed Elevator', 'Central A/C', '2-Car Garage'],
                'phone' => '+966500000000',
                'whatsapp' => '966500000000',
                'location_ar' => 'الرياض - حي النرجس',
                'location_en' => 'Riyadh - Al Narjis',
                'legal_status_ar' => 'صك إلكتروني جاهز للإفراغ الفوري',
                'legal_status_en' => 'Electronic Title Deed Ready for Transfer',
                'payment_system_ar' => 'كاش أو تمويل بنكي معتمد',
                'payment_system_en' => 'Cash or Bank Financing',
                'image_1' => null,
            ]);

            Property::create([
                'category_id' => $cat2->id,
                'name_ar' => 'شقة دوبلكس بإطلالة بانورامية',
                'name_en' => 'Duplex Apartment with Panoramic View',
                'area_ar' => '220 م²',
                'area_en' => '220 sqm',
                'description_ar' => 'شقة دوبلكس فسيحة بإطلالة ساحرة في موقع استراتيجي قريب من كافة الخدمات والمرافق الحيوية.',
                'description_en' => 'Spacious duplex apartment with captivating views in a prime location close to all key amenities.',
                'features_ar' => ['3 غرف نوم', 'صالة استقبال واسعة', 'مطبخ مجهز بالكامل', 'أمن وحراسة 24/7'],
                'features_en' => ['3 Bedrooms', 'Large Reception Hall', 'Fully Equipped Kitchen', '24/7 Security'],
                'phone' => '+966500000000',
                'whatsapp' => '966500000000',
                'location_ar' => 'الرياض - حي الملقا',
                'location_en' => 'Riyadh - Al Malqa',
                'legal_status_ar' => 'صك إلكتروني مستقل',
                'legal_status_en' => 'Independent Electronic Deed',
                'payment_system_ar' => 'دفعة أولى 20% وأقساط ميسرة',
                'payment_system_en' => '20% Down Payment & Easy Installments',
                'image_1' => null,
            ]);

            Property::create([
                'category_id' => $cat3->id,
                'name_ar' => 'مجمع مكتبي تجاري في موقع حيوي',
                'name_en' => 'Commercial Office Complex in Prime Location',
                'area_ar' => '850 م²',
                'area_en' => '850 sqm',
                'description_ar' => 'مبنى تجاري واستثماري مجهز للشركات الكبرى، يضمن عائداً استثمارياً سنوياً مجزياً.',
                'description_en' => 'Commercial investment building designed for major corporations, yielding rewarding annual ROI.',
                'features_ar' => ['واجهات زجاجية عصرية', 'مواقف خاصة للسيارات', 'نظام إطفاء متطور', 'موقع استثماري واعد'],
                'features_en' => ['Modern Glass Facades', 'Dedicated Parking', 'Advanced Fire Safety System', 'Prime Investment Area'],
                'phone' => '+966500000000',
                'whatsapp' => '966500000000',
                'location_ar' => 'الرياض - طريق الملك فهد',
                'location_en' => 'Riyadh - King Fahd Road',
                'legal_status_ar' => 'تراخيص بلدية وتجارية مكتملة',
                'legal_status_en' => 'Full Municipal and Commercial Permits',
                'payment_system_ar' => 'تسهيلات دفع خاصة للمستثمرين',
                'payment_system_en' => 'Special Payment Plans for Investors',
                'image_1' => null,
            ]);
        }

        // 5. FAQs
        if (DB::table('faqs')->count() == 0) {
            DB::table('faqs')->insert([
                [
                    'question_ar' => 'ما هي الخطوات اللازمة لشراء عقار من خلالكم؟',
                    'question_en' => 'What are the steps to purchase a property through you?',
                    'answer_ar' => 'تبدأ الخطوات باختيار العقار المناسب مع مستشارنا، ثم معاينة العقار ميدانياً، والتحقق من سلامة الأوراق والمستندات القانونية، وصولاً إلى توقيع العقود والإفراغ الإلكتروني المعتمد.',
                    'answer_en' => 'The process starts with selecting the right property, onsite inspection, legal verification, and finally the approved electronic title transfer.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'question_ar' => 'هل تقدمون استشارات وحلولاً تمويلية بنكية؟',
                    'question_en' => 'Do you provide financial and bank financing consulting?',
                    'answer_ar' => 'نعم، لدينا شراكات مع كبرى البنوك والمؤسسات التمويلية لتوفير أفضل الحلول التمويلية وأقل هوامش ربح ممكنة للعملاء.',
                    'answer_en' => 'Yes, we collaborate with top banks and financial entities to offer competitive financing solutions with minimal profit margins.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
