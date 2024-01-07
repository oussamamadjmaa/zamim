<?php

namespace Database\Seeders;

use App\Models\Subscription\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'key'   => 'monthly_plan',
            'name'  => 'Monthly subscription',
            'short_description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
            'features'  => [
                'يتضمن ما يلي :',
                'إدارة الإذاعات والفعاليات' => [
                    'إنشاء وجدولة الإذاعات بسهولة.',
                    'توزيع الأدوار بين المعلمين والطلاب بناءً على الجدول الزمني.',
                    'القدرة على تعديل وتحديث الإذاعات المجدولة.'
                ],
                'نظام تقييم متقدم' => [
                    'تقديم تقييمات دورية وشاملة لأداء المعلمين والطلاب.',
                    'تقديم ملاحظات بناءة من المشرفين والمدراء لتحفيز التحسين المستمر.'
                ],
               'تبادل المواضيع والمحتوى' => [
                'مشاركة المواضيع والمحتوى بين المدارس بشكل آمن ومراعاة للخصوصية.',
                'تعيين إذونات وتصاريح محددة لمشاركة المحتوى.'
               ],
               'نظام إشعارات فعّال' => [
                    'نظام إشعارات يساعد على التواصل الفعّال بين المدارس وأولياء الأمور.',
                    'إشعار فوري عبر البريد الإلكتروني أو رسائل نصية حول الأحداث والتحديثات.'
               ]
            ],
            'price'     => 120,
            'currency'   => 'AED',
            'billing_interval'  => 'month',
            'billing_period'    => 1,
            'sort_order'    => 2,
            'is_active' => 1,
            'is_featured'   => 0
        ]);

        Plan::create([
            'key'   => 'yearly_plan',
            'name'  => 'Yearly subscription',
            'short_description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
            'features'  => [
                'بالإضافة إلى جميع الخدمات المذكورة في الباقة الشهرية، يمكن للمشتركين في الباقة السنوية الاستفادة من :',
                'دعم فني مستمر' => [
                    ' دعم فني مميز على مدار السنة لحل المشكلات وتقديم الإرشاد.',
                    ' تحديثات منتظمة للمنصة لتحسين تجربة المستخدم وزيادة أمان البيانات.'
                ],
                'توفير ميزات إضافية' => [
                    'الوصول إلى ميزات إضافية تجعل تجربة الإذاعة المدرسية أكثر تفردًا وتحسينًا.',
                ],
            ],
            'price'     => 950,
            'currency'   => 'AED',
            'billing_interval'  => 'year',
            'billing_period'    => 1,
            'sort_order'    => 1,
            'is_active' => 1,
            'is_featured'   => 1
        ]);
    }
}
