<script setup>
import { RouterView } from 'vue-router';
import RelumeIcon from '../icons/RelumeIcon.vue';
</script>
<template>
    <!-- Start : subscription plans -->
    <div class="subscription-plans row mx-0">
        <div class="col-md-6 mb-4">
            <!-- Start : subscription plan card -->
            <div class="subscription-plan" data-aos="fade-up" data-aos-delay="300">
                <div class="subscription-plan__heading">
                    <div class="d-flex">
                        <h5 class="plan-period">
                            <RelumeIcon /><br>
                            <span>الباقة الشهرية</span>
                        </h5>
                        <h2 class="plan-price">150<span class="currency">ريال</span></h2>
                    </div>
                    <p class="plan-brief">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم</p>
                </div>
                <hr class="my-4">
                <div class="subscription-plan__features">
                    <p>يتضمن ما يلي :</p>
                    <ul class="plan-features m-0 list-unstyled mb-4 p-0">
                        <li class="plan-feature-item">
                            <span class="fs-5">إدارة الإذاعات والفعاليات</span>
                            <ul class="list-unstyled mb-3 ps-3">
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> إنشاء وجدولة الإذاعات بسهولة.</li>
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> توزيع الأدوار بين المعلمين والطلاب بناءً على الجدول الزمني.</li>
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> القدرة على تعديل وتحديث الإذاعات المجدولة.</li>
                            </ul>
                        </li>
                        <li class="plan-feature-item">
                            <span class="fs-5"> نظام تقييم متقدم</span>
                            <ul class="list-unstyled mb-3 ps-3">
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> تقديم تقييمات دورية وشاملة لأداء المعلمين والطلاب.</li>
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> تقديم ملاحظات بناءة من المشرفين والمدراء لتحفيز التحسين المستمر.</li>
                            </ul>
                        </li>
                        <li class="plan-feature-item">
                            <span class="fs-5"> تبادل المواضيع والمحتوى</span>
                            <ul class="list-unstyled mb-3 ps-3">
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon>  مشاركة المواضيع والمحتوى بين المدارس بشكل آمن ومراعاة للخصوصية.</li>
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> تعيين إذونات وتصاريح محددة لمشاركة المحتوى.</li>
                            </ul>
                        </li>
                        <li class="plan-feature-item">
                            <span class="fs-5"> نظام إشعارات فعّال</span>
                            <ul class="list-unstyled mb-3 ps-3">
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon>  نظام إشعارات يساعد على التواصل الفعّال بين المدارس وأولياء الأمور.</li>
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon>  إشعار فوري عبر البريد الإلكتروني أو رسائل نصية حول الأحداث والتحديثات.</li>
                            </ul>
                        </li>
                    </ul>

                    <RouterLink to="/subscription" class="button-main button-rounded w-100">اشترك الآن</RouterLink>
                </div>
            </div>
            <!-- End : subscription plan card -->
        </div>
        <div class="col-md-6 mb-4">
            <!-- Start : subscription plan card -->
            <div class="subscription-plan" data-aos="fade-up" data-aos-delay="500">
                <div class="subscription-plan__heading">
                    <div class="d-flex">
                        <h5 class="plan-period">
                            <RelumeIcon /><br>
                            <span>الباقة السنوية</span>
                        </h5>
                        <h2 class="plan-price">950<span class="currency">ريال</span></h2>
                    </div>
                    <p class="plan-brief">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم</p>
                </div>
                <hr class="my-4">
                <div class="subscription-plan__features">
                    <p>بالإضافة إلى جميع الخدمات المذكورة في الباقة الشهرية، يمكن للمشتركين في الباقة السنوية الاستفادة من :</p>
                    <ul class="plan-features m-0 list-unstyled mb-4 p-0">
                        <li class="plan-feature-item">
                            <span class="fs-5"> دعم فني مستمر</span>
                            <ul class="list-unstyled mb-3 ps-3">
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> دعم فني مميز على مدار السنة لحل المشكلات وتقديم الإرشاد.</li>
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> تحديثات منتظمة للمنصة لتحسين تجربة المستخدم وزيادة أمان البيانات.</li>
                            </ul>
                        </li>
                        <li class="plan-feature-item">
                            <span class="fs-5"> توفير ميزات إضافية</span>
                            <ul class="list-unstyled mb-3 ps-3">
                                <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> الوصول إلى ميزات إضافية تجعل تجربة الإذاعة المدرسية أكثر تفردًا وتحسينًا.</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <RouterLink to="/subscription" class="button-main button-rounded w-100">اشترك الآن</RouterLink>
            </div>
            <!-- End : subscription plan card -->
        </div>
    </div>
    <!-- End : subscription plans -->
</template>