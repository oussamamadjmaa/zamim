@extends('web.layouts.master')
@section('content')
        @include('web.layouts.partials.header')

        <!-- Start : Hero -->
        <section id="hero">
            <div class="container">
                <div class="row mx-0 align-items-center">
                    <div class="col-lg-6 mb-4">
                        <!-- Start : Hero content -->
                        <div class="hero-content">
                            <h1 class="welcome" data-aos="fade-up" data-aos-easing="ease-out-cubic">
                                أهلا بكم في الإذاعة
                                <div><span class="main-blue">المدرسية</span> الصباحــــــــــــية</div>
                            </h1>
                            <p data-aos="fade-up" data-aos-delay="100">منصة الإذاعة المدرسية هي أداة تعليمية مبتكرة تهدف إلى
                                تعزيز التفاعل والتواصل في بيئة التعليم. تعتبر هذه المنصة جسراً مهماً بين المدارس والطلاب وأولياء
                                الأمور، حيث تتيح للمدارس إدارة وتنظيم الإذاعات الصباحية بشكل مبتكر وبناء على معايير تقنية عالية.
                            </p>

                            <div>
                                <a href="#" class="button-main mb-2 me-md-3 me-2" data-aos="fade-up" data-aos-delay="200">تواصل
                                    معنا</a>
                                <a href="#" class="link-dark" data-aos="fade-up" data-aos-delay="300">عرض المزيد حول المنصة
                                    <ion-icon name="chevron-forward-outline"></ion-icon></a>
                            </div>

                            <div class="ellipse-87"></div>
                            <div class="ellipse-89"></div>
                            <div class="ellipse-90"></div>
                        </div>
                        <!-- End : Hero content -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Start : Hero Image -->
                        <div class="hero-image">
                            <img src="/web-assets/images/hero.jpeg" data-aos="fade-right">

                            <div class="service-rating text-center" data-aos="fade-right" data-aos-delay="100">
                                <div><img src="/web-assets/images/star.svg"> <span class="main-gray">خدمة ممتازة</span></div>
                                <h5>أكثر من 50 مدرسة</h5>
                            </div>
                        </div>
                        <!-- End : Hero Image -->
                    </div>
                </div>
                <div class="text-center">
                    <a class="mouse-scroll" href="#whyus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M28.5 25.5C28.5 28.2848 27.3938 30.9555 25.4246 32.9246C23.4555 34.8938 20.7848 36 18 36C15.2152 36 12.5445 34.8938 10.5754 32.9246C8.60625 30.9555 7.5 28.2848 7.5 25.5V16.5C7.5 15.1211 7.77159 13.7557 8.29926 12.4818C8.82694 11.2079 9.60036 10.0504 10.5754 9.07538C11.5504 8.10036 12.7079 7.32694 13.9818 6.79926C15.2557 6.27159 16.6211 6 18 6C19.3789 6 20.7443 6.27159 22.0182 6.79926C23.2921 7.32694 24.4496 8.10036 25.4246 9.07538C26.3996 10.0504 27.1731 11.2079 27.7007 12.4818C28.2284 13.7557 28.5 15.1211 28.5 16.5V25.5ZM16.5 28.5C16.5 28.8978 16.658 29.2794 16.9393 29.5607C17.2206 29.842 17.6022 30 18 30C18.3978 30 18.7794 29.842 19.0607 29.5607C19.342 29.2794 19.5 28.8978 19.5 28.5V22.5C19.5 22.1022 19.342 21.7206 19.0607 21.4393C18.7794 21.158 18.3978 21 18 21C17.6022 21 17.2206 21.158 16.9393 21.4393C16.658 21.7206 16.5 22.1022 16.5 22.5V28.5Z"
                                fill="#D95D13" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        <!-- End : Hero -->

        <!-- Start : Why us -->
        <section id="whyus">
            <div class="container">
                <!-- Start : Why us brief -->
                <div class="section-heading">
                    <h6 data-aos="fade-up" data-aos-delay="200">لوريم ايبسوم</h6>
                    <h4 data-aos="fade-up" data-aos-delay="300">لماذا قد تختار <span class="main-blue">صوت المدرسة</span>
                        لإذاعتك المدرسية ؟</h4>
                    <p data-aos="fade-up" data-aos-delay="400">منصتنا الفريدة تجمع بين التكنولوجيا الحديثة والتعليم التفاعلي
                        لخلق تجربة تعليمية محورية. إنها أداة قوية تسهل عملية تنظيم وإدارة الإذاعات الصباحية في المدارس بأسلوب
                        فعّال وبناء. من خلال منصتنا، يمكن للمديرين والمعلمين والطلاب التفاعل بسهولة والمشاركة في تنظيم وتقديم
                        الإذاعات وتقييم الأداء بناءً على معايير محددة</p>
                </div>
                <!-- End : Why us brief -->

                <!-- Start : Why us cards -->
                <div class="whyus-cards row mx-0">
                    <div class="col-md-4">
                        <!-- Start : Why us card -->
                        <div class="whyus-card" data-aos="fade-up" data-aos-delay="300">
                            <h5>
                                <x-icons.relume /> تخصصنا في مجال التعليم
                            </h5>
                            <p>نفهم أهمية البيئة التعليمية والتفاعلية لتعزيز تعليم الطلاب. منصتنا تم تصميمها خصيصًا لتلبية
                                احتياجات المدارس والمعلمين.</p>
                        </div>
                        <!-- End : Why us card -->
                    </div>
                    <div class="col-md-4">
                        <!-- Start : Why us card -->
                        <div class="whyus-card" data-aos="fade-up" data-aos-delay="500">
                            <h5>
                                <x-icons.relume /> مشاركة الطلاب والمعلمين
                            </h5>
                            <p>يتيح للمعلمين والطلاب المشاركة بفعالية في الإذاعة المدرسية من خلال التعليقات والتقييمات
                                والمناقشات.</p>
                        </div>
                        <!-- End : Why us card -->
                    </div>
                    <div class="col-md-4">
                        <!-- Start : Why us card -->
                        <div class="whyus-card" data-aos="fade-up" data-aos-delay="700">
                            <h5>
                                <x-icons.relume /> إمكانيات إدارة متقدمة
                            </h5>
                            <p>نقدم أدوات تحرير وإدارة برامج الإذاعة بسهولة. يمكنك التخطيط والتنظيم والتعديل على البرامج بسرعة
                                وفعالية.</p>
                        </div>
                        <!-- End : Why us card -->
                    </div>
                </div>
                <!-- End : Why us cards -->
            </div>
        </section>
        <!-- Start : Why us -->

        <!-- Start : Our Features -->
        <section id="our-features">
            <div class="container">
                <!-- Start : Feature row -->
                <div class="feature-row row mx-0 align-items-center">
                    <div class="col-md-6">
                        <div class="feature-image" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-image-content">
                                <img src="/web-assets/images/pic1.jpeg" alt="Feature 1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-description">
                            <h4 data-aos="fade-up" data-aos-delay="400">لوريم إيبسوم</h4>
                            <p data-aos="fade-up" data-aos-delay="500">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على
                                العميل ليتصور طريقه وضع النصوص بالتصاميم
                                سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...</p>
                            <div>
                                <a href="#" class="button-main mb-2 me-md-3 me-2" data-aos="fade-up" data-aos-delay="200">تواصل
                                    معنا</a>
                                <a href="#" class="link-dark" data-aos="fade-up" data-aos-delay="300">عرض المزيد حول المنصة
                                    <ion-icon name="chevron-forward-outline"></ion-icon></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End : Feature row -->

                <!-- Start : Feature row -->
                <div class="feature-row row mx-0 align-items-center">
                    <div class="col-md-6">
                        <div class="feature-image" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-image-content">
                                <img src="/web-assets/images/pic2.jpeg" alt="Feature 2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-description">
                            <h4 data-aos="fade-up" data-aos-delay="400">لوريم إيبسوم</h4>
                            <p data-aos="fade-up" data-aos-delay="500">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على
                                العميل ليتصور طريقه وضع النصوص بالتصاميم
                                سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...</p>
                            <div>
                                <a href="#" class="button-main mb-2 me-md-3 me-2" data-aos="fade-up" data-aos-delay="200">تواصل
                                    معنا</a>
                                <a href="#" class="link-dark" data-aos="fade-up" data-aos-delay="300">عرض المزيد حول المنصة
                                    <ion-icon name="chevron-forward-outline"></ion-icon></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End : Feature row -->

                <!-- Start : Feature row -->
                <div class="feature-row row mx-0 align-items-center">
                    <div class="col-md-6">
                        <div class="feature-image" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-image-content">
                                <img src="/web-assets/images/pic3.png" alt="Feature 3">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-description">
                            <h4 data-aos="fade-up" data-aos-delay="400">لوريم إيبسوم</h4>
                            <p data-aos="fade-up" data-aos-delay="500">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على
                                العميل ليتصور طريقه وضع النصوص بالتصاميم
                                سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...</p>
                            <div>
                                <a href="#" class="button-main mb-2 me-md-3 me-2" data-aos="fade-up" data-aos-delay="200">تواصل
                                    معنا</a>
                                <a href="#" class="link-dark" data-aos="fade-up" data-aos-delay="300">عرض المزيد حول المنصة
                                    <ion-icon name="chevron-forward-outline"></ion-icon></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End : Feature row -->
            </div>
        </section>
        <!-- End : Our Features -->

        <!-- Start : Our Services -->
        <section id="our-services">
            <div class="container">
                <div class="row mx-0 align-items-center">
                    <!-- Start : Services brief -->
                    <div class="col-lg-6 text-center text-md-start services-desc">
                        <h6 class="main-blue" data-aos="fade-up" data-aos-delay="300">خدماتنا</h6>
                        <h4 data-aos="fade-up" data-aos-delay="400">نحن هنا لتعزيز تجربة الإذاعة المدرسية</h4>
                        <p data-aos="fade-up" data-aos-delay="500">خدماتنا مصممة لتعزيز تنظيم وتفاعل الإذاعة المدرسية وتقديم
                            تجربة تعليمية محسنة للمعلمين والطلاب. انضم إلينا اليوم واستمتع بمزايا منصتنا الشاملة.</p>
                    </div>
                    <!-- End : Services brief -->

                    <div class="col-lg-6">
                        <div class="services-cards row mx-0">
                            <div class="col-sm-6">
                                <!-- Start : Service card -->
                                <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                                    <h3>
                                        <x-icons.relume /> إدارة الإذاعات والفعاليات
                                    </h3>
                                    <ul class="fs-6 list-unstyled">
                                        <li>إمكانية إنشاء إذاعات جديدة وتحديد الأدوار بسهولة.</li>
                                        <li>جدولة الإذاعات وتوزيع المهام بين المعلمين والطلاب بناءً على الجدول الزمني.</li>
                                        <li>القدرة على تعديل وتحديث الإذاعات المجدولة بسرعة.</li>
                                    </ul>
                                </div>
                                <!-- End : Service card -->
                            </div>

                            <div class="col-sm-6">
                                <!-- Start : Service card -->
                                <div class="service-card" data-aos="fade-up" data-aos-delay="500">
                                    <h3>
                                        <x-icons.relume /> نظام تقييم متقدم
                                    </h3>
                                    <ul class="fs-6 list-unstyled">
                                        <li>تقديم تقييمات دورية وشاملة لأداء المعلمين والطلاب.</li>
                                        <li>تقديم ملاحظات بناءة من المشرفين والمدراء لتحفيز التحسين المستمر.</li>
                                    </ul>
                                </div>
                                <!-- End : Service card -->
                            </div>
                            <div class="col-sm-6">
                                <!-- Start : Service card -->
                                <div class="service-card" data-aos="fade-up" data-aos-delay="700">
                                    <h3>
                                        <x-icons.relume /> تبادل المواضيع والمحتوى
                                    </h3>
                                    <ul class="fs-6 list-unstyled">
                                        <li>إمكانية مشاركة المواضيع والمحتوى بين المدارس بشكل آمن ومراعاة للخصوصية.</li>
                                        <li>تعيين إذونات وتصاريح محددة لمشاركة المحتوى.</li>
                                    </ul>
                                </div>
                                <!-- End : Service card -->
                            </div>
                            <div class="col-sm-6">
                                <!-- Start : Service card -->
                                <div class="service-card" data-aos="fade-up" data-aos-delay="900">
                                    <h3>
                                        <x-icons.relume /> نظام إشعارات فعّال
                                    </h3>
                                    <ul class="fs-6 list-unstyled">
                                        <li>نظام إشعارات يساعد على التواصل الفعّال بين المدارس وأولياء الأمور.</li>
                                        <li>إشعار فوري عبر البريد الإلكتروني أو رسائل نصية حول الأحداث والتحديثات.</li>
                                    </ul>
                                </div>
                                <!-- End : Service card -->
                            </div>
                            <div class="col-sm-6">
                                <!-- Start : Service card -->
                                <div class="service-card" data-aos="fade-up" data-aos-delay="1000">
                                    <h3>
                                        <x-icons.relume /> أمان وخصوصية مضمونة
                                    </h3>
                                    <ul class="fs-6 list-unstyled">
                                        <li> تطبيق تقنيات حماية البيانات والمعلومات للحفاظ على خصوصيتك وأمانك.</li>
                                        <li> عدم تداخل البيانات والمعلومات بين المدارس لضمان السرية.</li>
                                    </ul>
                                </div>
                                <!-- End : Service card -->
                            </div>
                            <div class="col-sm-6">
                                <!-- Start : Service card -->
                                <div class="service-card" data-aos="fade-up" data-aos-delay="1100">
                                    <h3>
                                        <x-icons.relume /> دعم فني مستمر
                                    </h3>
                                    <ul class="fs-6 list-unstyled">
                                        <li>دعم فني مميز لضمان سلاسة الاستخدام وحل المشكلات.</li>
                                        <li> تقديم تحديثات منتظمة لتحسين تجربة المستخدم وأمان البيانات.</li>
                                    </ul>
                                </div>
                                <!-- End : Service card -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End : Our Services Section -->

        <!-- Start : Subscription -->
        <section id="subscription-section">
            <div class="container py-5 my-md-5">
                <!-- Start : Subscription Feature row -->
                <div class="feature-row row mx-0 align-items-center pb-md-5 mb-5">
                    <div class="col-md-6">
                        <div class="feature-image">
                            <div class="multiple-feature-image">
                                <img src="/web-assets/images/pic4.jpg" data-aos="fade-up" data-aos-delay="300">
                                <img src="/web-assets/images/pic5.jpg" data-aos="fade-up" data-aos-delay="400">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-description">
                            <h4 data-aos="fade-up" data-aos-delay="300">مهتم بالاشتراك؟</h4>
                            <p data-aos="fade-up" data-aos-delay="400">
                                هل تبحث عن طريقة لتحسين تجربة الإذاعة المدرسية في مدرستك؟ إذا كنت مهتمًا بالاشتراك، فنحن هنا
                                لنقدم لك فرصة استثنائية. انضم إلى منصتنا الفريدة اليوم واستعد لاكتشاف عالم جديد من التعليم.
                                <br><br>
                                من خلال خدماتنا، ستحصل على القدرة على إدارة الإذاعات والفعاليات بكل سهولة، وتقديم تقييمات شاملة
                                لأداء المعلمين والطلاب، والمشاركة بأمان في تبادل المواضيع مع المدارس الأخرى. نحن نضمن أن تكون
                                بيئة التعلم في مدرستك أكثر تفاعلًا وتحفيزًا.
                                <br><br>
                                انضم إلينا اليوم لتشهد الفارق بنفسك. انضم إلى مجتمع من المدارس الذين يسعون إلى تعزيز تجربة
                                التعليم والتواصل بأسلوب مبتكر وفعال. لا تفوت هذه الفرصة الرائعة، انضم الآن
                            </p>
                            <div>
                                <a href="{{ route('school.register') }}" class="button-main mb-2 me-md-3 me-2">انضم
                                    الآن</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End : Subscription Feature row -->

                <!-- Start : subscription heading -->
                <div class="section-heading pt-3 pt-md-5 mt-5">
                    <h6 data-aos="fade-up" data-aos-delay="200">اشتركوا معنا على صوت المدرسة</h6>
                    <h4 data-aos="fade-up" data-aos-delay="300">تسعيرة الإشتراك</h4>
                    <p data-aos="fade-up" data-aos-delay="400">اختيار الباقة المناسبة يعتمد على احتياجات مدرستك وتفضيلاتك. سواء كنت تفضل الاشتراك الشهري لمرونة أكبر أو تفضل الباقة السنوية للتوفير الإضافي والميزات الإضافية، ستجد في منصتنا الخدمات التي تلبي احتياجاتك.</p>
                </div>
                <!-- End : subscription heading -->

                @include('web.includes.plans-list')
            </div>
        </section>
        <!-- End : Subscription Section -->

        <!-- Start : Our subscribers -->
        <section id="our-subscribers">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 data-aos="fade-up" data-aos-delay="300">بعض من مشتركينا</h4>
                        <p data-aos="fade-up" data-aos-delay="400">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على
                            العميل ليتصور طريقه وضع النصوص بالتصاميم,</p>
                        <a href="{{ route('school.register') }}" class="button-secondary" data-aos="fade-up" data-aos-delay="500">سجل الآن</a>
                    </div>
                    <div class="col mt-5 mt-md-0">
                        <our-subscribers-slider-component />
                    </div>
                </div>
            </div>
        </section>
        <!-- End : Our subscribers -->

        <!-- Start : FAQ -->
        <section id="faq">
            <div class="container">
                <div class="text-center">
                    <h4 data-aos="fade-up" data-aos-delay="300">الأسئلة الشائعة</h4>
                    <p class="col-md-8 col-lg-6 mx-auto mb-5" data-aos="fade-up" data-aos-delay="400">لوريم ايبسوم هو نموذج
                        افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ...
                        بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ...</p>
                </div>

                <div>
                    <faq-item-component data-aos="fade-up" data-aos-delay="300">
                        <template #question>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم</template>
                        <template #answer>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع
                            النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع
                            انترنت ... </template>
                    </faq-item-component>

                    <faq-item-component data-aos="fade-up" data-aos-delay="300">
                        <template #question>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم</template>
                        <template #answer>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع
                            النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع
                            انترنت ... </template>
                    </faq-item-component>

                    <faq-item-component data-aos="fade-up" data-aos-delay="300">
                        <template #question>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم</template>
                        <template #answer>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع
                            النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع
                            انترنت ... </template>
                    </faq-item-component>

                    <faq-item-component data-aos="fade-up" data-aos-delay="400">
                        <template #question>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم</template>
                        <template #answer>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع
                            النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع
                            انترنت ... </template>
                    </faq-item-component>
                </div>

                <div class="text-center mt-5">
                    <h5 data-aos="fade-up" data-aos-delay="300">لازلت تمتلك أسئلة؟</h5>
                    <p data-aos="fade-up" data-aos-delay="400">تواصل معنا بالضغط على الزر أدناه</p>
                    <a href="#" class="button-main" data-aos="fade-up" data-aos-delay="500">تواصل معنا</a>
                </div>

                <div>
                    <div class="ellipse-87"></div>
                    <div class="ellipse-89"></div>
                    <div class="ellipse-90"></div>
                </div>
            </div>
        </section>
        <!-- End : FAQ -->

        @include('web.layouts.partials.footer')
@endsection
