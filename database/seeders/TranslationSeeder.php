<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\TranslationLoader\LanguageLine;

class TranslationSeeder extends Seeder
{
    public function run()
    {
        $translations = [
            // General Menu
            ['group' => 'menu', 'key' => 'home', 'text' => ['en' => 'Home', 'hi' => 'होम', 'ar' => 'الرئيسية']],
            ['group' => 'menu', 'key' => 'flights', 'text' => ['en' => 'Flights', 'hi' => 'फ्लाइट्स', 'ar' => 'رحلات الطيران']],
            ['group' => 'menu', 'key' => 'hotels', 'text' => ['en' => 'Hotels', 'hi' => 'होल्ड्स', 'ar' => 'الفنادق']],
            ['group' => 'menu', 'key' => 'tours', 'text' => ['en' => 'Tours', 'hi' => 'टूर्स', 'ar' => 'جولات']],
            ['group' => 'menu', 'key' => 'cargo', 'text' => ['en' => 'Cargo', 'hi' => 'कार्गो', 'ar' => 'الشحن']],
            ['group' => 'menu', 'key' => 'visa', 'text' => ['en' => 'Visa', 'hi' => 'वीजा', 'ar' => 'تأشيرة']],
            
            // Buttons
            ['group' => 'buttons', 'key' => 'search', 'text' => ['en' => 'Search', 'hi' => 'खोजें', 'ar' => 'بحث']],
            ['group' => 'buttons', 'key' => 'book_now', 'text' => ['en' => 'Book Now', 'hi' => 'अभी बुक करें', 'ar' => 'احجز الآن']],
            ['group' => 'buttons', 'key' => 'view_detail', 'text' => ['en' => 'View Detail', 'hi' => 'विवरण देखें', 'ar' => 'عرض التفاصيل']],
            ['group' => 'buttons', 'key' => 'login', 'text' => ['en' => 'Login', 'hi' => 'लॉगिन', 'ar' => 'تسجيل الدخول']],
            ['group' => 'buttons', 'key' => 'signup', 'text' => ['en' => 'Sign Up', 'hi' => 'साइन अप', 'ar' => 'أنشئ حساباً']],

            // Validation
            ['group' => 'validation', 'key' => 'required', 'text' => ['en' => 'The :attribute field is required.', 'hi' => ':attribute फ़ील्ड आवश्यक है।', 'ar' => 'حقل :attribute مطلوب.']],
            ['group' => 'validation', 'key' => 'email', 'text' => ['en' => 'The :attribute must be a valid email address.', 'hi' => ':attribute एक मान्य ईमेल पता होना चाहिए।', 'ar' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالحًا.']],

            // Categories
            ['group' => 'categories', 'key' => 'adventure', 'text' => ['en' => 'Adventure', 'hi' => 'साहसिक', 'ar' => 'مغامرة']],
            ['group' => 'categories', 'key' => 'romantic', 'text' => ['en' => 'Romantic', 'hi' => 'रोमांटिक', 'ar' => 'رومانسي']],
            ['group' => 'categories', 'key' => 'family', 'text' => ['en' => 'Family', 'hi' => 'पारिवारिक', 'ar' => 'عائلي']],
            ['group' => 'categories', 'key' => 'luxury', 'text' => ['en' => 'Luxury', 'hi' => 'लक्जरी', 'ar' => 'فاخر']],
            ['group' => 'categories', 'key' => 'flights', 'text' => ['en' => 'Flights', 'hi' => 'फ्लाइट्स', 'ar' => 'رحلات']],
            ['group' => 'categories', 'key' => 'hotels', 'text' => ['en' => 'Hotels', 'hi' => 'होल्ड्स', 'ar' => 'فنادق']],
            ['group' => 'categories', 'key' => 'cabs', 'text' => ['en' => 'Cabs', 'hi' => 'कैब्स', 'ar' => 'سيارات الأجرة']],
            ['group' => 'categories', 'key' => 'trains', 'text' => ['en' => 'Trains', 'hi' => 'ट्रेनें', 'ar' => 'القطارات']],
            ['group' => 'categories', 'key' => 'insurance', 'text' => ['en' => 'Insurance', 'hi' => 'बीमा', 'ar' => 'تأمين']],
            ['group' => 'categories', 'key' => 'esim', 'text' => ['en' => 'eSIM', 'hi' => 'eSIM', 'ar' => 'شريحة إلكترونية']],
            ['group' => 'categories', 'key' => 'barber', 'text' => ['en' => 'Barber', 'hi' => 'नाई', 'ar' => 'حلاق']],
            ['group' => 'categories', 'key' => 'tutor', 'text' => ['en' => 'Tutor', 'hi' => 'ट्यूटर', 'ar' => 'مدرس خصوصي']],
            ['group' => 'categories', 'key' => 'cleaner', 'text' => ['en' => 'Cleaner', 'hi' => 'क्लीनर', 'ar' => 'عامل نظافة']],

            // Common Labels
            ['group' => 'labels', 'key' => 'destination', 'text' => ['en' => 'Destination', 'hi' => 'गंतव्य', 'ar' => 'الوجهة']],
            ['group' => 'labels', 'key' => 'check_in', 'text' => ['en' => 'Check In', 'hi' => 'चेक इन', 'ar' => 'تسجيل الوصول']],
            ['group' => 'labels', 'key' => 'check_out', 'text' => ['en' => 'Check Out', 'hi' => 'चेक आउट', 'ar' => 'تسجيل المغادرة']],
            ['group' => 'labels', 'key' => 'guests', 'text' => ['en' => 'Guests', 'hi' => 'अतिथि', 'ar' => 'ضيوف']],
            ['group' => 'labels', 'key' => 'where', 'text' => ['en' => 'Where', 'hi' => 'कहाँ', 'ar' => 'أين']],
            ['group' => 'labels', 'key' => 'service', 'text' => ['en' => 'Service', 'hi' => 'सेवा', 'ar' => 'خدمة']],
            ['group' => 'labels', 'key' => 'all_services', 'text' => ['en' => 'All Services', 'hi' => 'सभी सेवाएँ', 'ar' => 'جميع الخدمات']],
            ['group' => 'labels', 'key' => 'find_best_pro', 'text' => ['en' => 'Find the best local professionals near you', 'hi' => 'अपने आस-पास के सबसे अच्छे स्थानीय पेशेवरों को खोजें', 'ar' => 'ابحث عن أفضل المحترفين المحليين بالقرب منك']],
            ['group' => 'labels' , 'key' => 'marketplace_title', 'text' => ['en' => 'Service Marketplace', 'hi' => 'सेवा मार्केटप्लेस', 'ar' => 'سوق الخدمات']],
        ];

        foreach ($translations as $t) {
            LanguageLine::updateOrCreate(
                ['group' => $t['group'], 'key' => $t['key']],
                ['text' => $t['text']]
            );
        }
    }
}
