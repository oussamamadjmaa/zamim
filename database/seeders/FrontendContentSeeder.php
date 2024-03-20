<?php

namespace Database\Seeders;

use App\Models\FrontendContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontendContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = [
            'hero' => [
                'title' => 'أهلا بكم في الإذاعة <div><span class="main-blue">المدرسية</span> الصباحــــــــــــية</div>',
                'description' => 'منصة الإذاعة المدرسية هي أداة تعليمية مبتكرة تهدف إلى تعزيز التفاعل والتواصل في بيئة التعليم. تعتبر هذه المنصة جسراً مهماً بين المدارس والطلاب وأولياء الأمور، حيث تتيح للمدارس إدارة وتنظيم الإذاعات الصباحية بشكل مبتكر وبناء على معايير تقنية عالية.',
                'button_1' => [
                    'text' => 'تواصل معنا',
                    'url' => '#'
                ],
                'button_2' => [
                    'text' => 'عرض المزيد حول المنصة',
                    'url' => '#'
                ],
            ],
            'whyus' => [
                'heading_text' => 'لوريم ايبسوم',
                'title' => 'لماذا قد تختار <span class="main-blue">صوت المدرسة</span> لإذاعتك المدرسية ؟',
                'description' => 'منصتنا الفريدة تجمع بين التكنولوجيا الحديثة والتعليم التفاعلي لخلق تجربة تعليمية محورية. إنها أداة قوية تسهل عملية تنظيم وإدارة الإذاعات الصباحية في المدارس بأسلوب فعّال وبناء. من خلال منصتنا، يمكن للمديرين والمعلمين والطلاب التفاعل بسهولة والمشاركة في تنظيم وتقديم الإذاعات وتقييم الأداء بناءً على معايير محددة'
            ],
            'features' => [
                [
                    'image' => '/web-assets/images/pic1.jpeg',
                    'title' => 'لوريم إيبسوم',
                    'description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...',
                    'button_1' => [
                        'text' => 'تواصل معنا',
                        'url' => '#'
                    ],
                    'button_2' => [
                        'text' => 'عرض المزيد حول المنصة',
                        'url' => '#'
                    ],
                ],[
                    'image' => '/web-assets/images/pic2.jpeg',
                    'title' => 'لوريم إيبسوم',
                    'description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...',
                    'button_1' => [
                        'text' => 'تواصل معنا',
                        'url' => '#'
                    ],
                    'button_2' => [
                        'text' => 'عرض المزيد حول المنصة',
                        'url' => '#'
                    ],
                ],[
                    'image' => '/web-assets/images/pic3.png',
                    'title' => 'لوريم إيبسوم',
                    'description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...',
                    'button_1' => [
                        'text' => 'تواصل معنا',
                        'url' => '#'
                    ],
                    'button_2' => [
                        'text' => 'عرض المزيد حول المنصة',
                        'url' => '#'
                    ],
                ]
            ],
            'subscribers' => [
                'title' => 'بعض من مشتركينا',
                'description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم,',
                'button' => [
                    'text' => 'سجل الآن',
                    'url' => '#'
                ],
                'list' => [
                    [
                        'cover' => 'web-assets/images/slider1.jpeg',
                        'avatar' => 'web-assets/images/school-avatar.jpeg',
                        'name'  => 'الإذاعة المدرسية رقم 1',
                        'students_count' => 120
                    ],[
                        'cover' => 'web-assets/images/slider2.jpeg',
                        'avatar' => 'web-assets/images/school-avatar.jpeg',
                        'name'  => 'الإذاعة المدرسية رقم 2',
                        'students_count' => 120
                    ],[
                        'cover' => 'web-assets/images/slider3.jpeg',
                        'avatar' => 'web-assets/images/school-avatar.jpeg',
                        'name'  => 'الإذاعة المدرسية رقم 3',
                        'students_count' => 120
                    ]
                ]
            ],
            'faq' => [
                'title' => 'الأسئلة الشائعة',
                'description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...',
                'list' => [
                    [
                        'question' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
                        'answer' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ... '
                    ],
                    [
                        'question' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
                        'answer' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ... '
                    ],
                    [
                        'question' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
                        'answer' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ... '
                    ],
                    [
                        'question' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
                        'answer' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ... '
                    ]
                ]
                    ],
            'footer' => [
                'description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...',
                'copyright_text' => 'جميع الحقوق محفوظة لصوت المدرسة، 2023',
                'social_media' => [
                    [
                        'title' => 'Linkedin',
                        'icon' => '<ion-icon name="logo-linkedin"></ion-icon>',
                        'url' => '#',
                    ],
                    [
                        'title' => 'Instagram',
                        'icon' => '<ion-icon name="logo-instagram"></ion-icon>',
                        'url' => '#',
                    ],
                    [
                        'title' => 'Twitter',
                        'icon' => '<ion-icon name="logo-twitter"></ion-icon>',
                        'url' => '#',
                    ],
                    [
                        'title' => 'Facebook',
                        'icon' => '<ion-icon name="logo-facebook"></ion-icon>',
                        'url' => '#',
                    ],
                    [
                        'title' => 'Youtube',
                        'icon' => '<ion-icon name="logo-youtube"></ion-icon>',
                        'url' => '#',
                    ]
                ]
            ]
        ];

        foreach ($contents as $section => $content) {
            FrontendContent::updateOrCreate(
                [
                    'section' => $section,
                ],
                [
                    'content' => $content,
                    'active'  => 1
                ]
            );
        }
    }
}
