
<script setup>
import { ref } from 'vue';
import useCommon from '../../../vue-services/common';
import InputComponent from '../../../vue-components/FormParts/InputComponent.vue';

const { callApi } = useCommon()

const registrationForm = ref({
    processing: false,
    show: false,
    response: null,
    errors: [],
    data: { step: 1,email: '', password:'', password_confirmation: '', accept_terms: false, country: 'المملكة العربية السعودية' , city: '', name: '', accreditation_number: '', mod_name: '', id_number: '', acknowledgment: false},
})


const nextStep = async () => {
    registrationForm.value.response = null
    registrationForm.value.errors = []
    registrationForm.value.processing = true

    const res = await callApi({ url: '/register', method: 'POST', data: registrationForm.value.data })
    registrationForm.value.processing = false
    registrationForm.value.response = res

    if (res.status == 200) {
        registrationForm.value.data.step = res.data.next_step
    } else if (res.status == 422) {
        registrationForm.value.errors = res.data.errors || []
    }
}
</script>
<template>
    <div class="mb-3 mb-md-5" v-if="registrationForm.data.step != 3">
        <h1 class="main-blue" data-aos="fade-up" data-aos-delay="300">تسجيل</h1>
        <p data-aos="fade-up" data-aos-delay="400">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم
            لتعرض على العميل.</p>
    </div>

    <form class="auth-form-box">
        <div v-if="registrationForm.data.step == 1">
            <InputComponent type="email" :errors="registrationForm.errors.email" label='<ion-icon name="person"></ion-icon>' placeholder="Email Address" v-model='registrationForm.data.email' :required="true" />
            <InputComponent type="password" :errors="registrationForm.errors.password" label='<ion-icon name="lock-open"></ion-icon>' placeholder="Password"  v-model='registrationForm.data.password' :required="true" />
            <InputComponent type="password" :errors="registrationForm.errors.password_confirmation" label='<ion-icon name="lock-open"></ion-icon>' placeholder="Confirm Password" v-model='registrationForm.data.password_confirmation' :required="true" />


            <div class="d-flex flex-wrap justify-content-between mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" v-model="registrationForm.data.accept_terms" id="accept_terms">
                    <label class="form-check-label" for="accept_terms">
                        اوافق على <a href="#">شروط و أحكام الموقع</a>
                    </label>
                </div>
            </div>

            <button type="button" class="button-main w-100" @click="nextStep()">انشاء حساب</button>
        </div>

        <div v-if="registrationForm.data.step == 2">
            <InputComponent :errors="registrationForm.errors.country" label='<ion-icon name="globe"></ion-icon>' placeholder="Country" v-model='registrationForm.data.country' :required="true" :readonly="true" />

            <InputComponent :errors="registrationForm.errors.city" label='<ion-icon name="location"></ion-icon>' placeholder="City" v-model='registrationForm.data.city' :required="true" />

            <InputComponent :errors="registrationForm.errors.name" label='<ion-icon name="school"></ion-icon>' placeholder="School name" v-model='registrationForm.data.name' :required="true" />

            <InputComponent :errors="registrationForm.errors.accreditation_number" label='<ion-icon name="at"></ion-icon>' placeholder="Accreditation number" v-model='registrationForm.data.accreditation_number' :required="true" />

            <InputComponent :errors="registrationForm.errors.mod_name" label='<ion-icon name="person"></ion-icon>' placeholder="Moderator fullname" v-model='registrationForm.data.mod_name' :required="true" />

            <InputComponent :errors="registrationForm.errors.id_number" label='<ion-icon name="person"></ion-icon>' placeholder="ID Number" v-model='registrationForm.data.id_number' :required="true" />

            <div class="d-flex flex-wrap justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" v-model="registrationForm.data.acknowledgment" id="acknowledgment">
                    <label class="form-check-label" for="acknowledgment">
                        أقر بأن هذه المعلومات صحيحة
                    </label>
                </div>

                <a href="javascript:;" @click="nextStep()">التالي <ion-icon
                        name="chevron-forward-outline"></ion-icon></a>
            </div>
        </div>

        <div v-if="registrationForm.data.step == 3">
            <div>
                <h5>معلومات الدفع</h5>
                <p>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل.</p>

                <div id="AmazonPayButton"></div>

                <button type="button" class="button-main w-100 mt-5">انشاء حساب</button>
            </div>
        </div>
    </form>

    <div class="text-center py-3" v-if="registrationForm.data.step == 1">
        تمتلك حسابا على منصتنا؟ <a href="/login">تسجيل الدخول</a>
    </div>
</template>
