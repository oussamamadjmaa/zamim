<script setup>
import { watchEffect, inject, ref, computed } from 'vue';
import useRadios from '../services/radios-service.js'
import useStudents from '../services/students-service.js'
import useTeachers from '../services/teachers-service.js'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';

const trans = inject('trans');


const { radios, getRadios, getRadio, storeRadio, radioForm, destroyRadio } = useRadios()
const { students, getStudents } = useStudents()
const { teachers, getTeachers } = useTeachers()

const createRadio = async () => {
    await storeRadio();

    if (radioForm.value.response.status == 200 && !radioForm.value.update) {
        radioForm.value.show = false;
        radioBgImage.value = null;
    }
}
const editRadio = async (radio) => {
    radios.value.isProccessing = true
    radio = await getRadio(radio.id)
    radios.value.isProccessing = false
    if (!radio) return;

    radios.value.list = radios.value.list.map((techRec) => techRec.id == radio.id ? radio : techRec)

    radioForm.value.show = true
    const studentsIds = radio.students.map(student => student.id)
    radioForm.value.data = { name: radio.name, class: radio.class, radio_date: radio.radioDate, teacher_id: radio.teacher.id, students: studentsIds, bg_image: radio.bgImage.path }
    radioBgImage.value = radio.bgImage;

    radioForm.value.update = radio
}

const closeModal = () => {
    radioForm.value.show = false
    radioForm.value.errors = []
    radioBgImage.value = null
}

watchEffect(() => {
    if (!radioForm.value.show) {
        radioForm.value.response = null
        radioForm.value.errors = []
        if (radioForm.value.update) {
            radioForm.value.data = radioForm.value.defaultData;
            radioForm.value.update = null
        }

    }
})

const studentsList = computed(() => {
    const result = { ...students.value.list };

    Object.keys(result).forEach((key) => {
        if ((radioForm.value.data.students).includes(parseInt(key))) {
            delete result[key];
        }
    });
    return result;
})

const deleteRadio = (radio) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroyRadio(radio)
}

const radioBgImage = ref(null);
const onBgUpload = (data) => {
    radioBgImage.value = data;
}

getRadios()

const onSelectAddStudent = (studentId) => {
    radioForm.value.data.students = [...radioForm.value.data.students, parseInt(studentId)]
}

const onSelectDeleteStudent = (studentId) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    radioForm.value.data.students = radioForm.value.data.students.filter(sId => sId != studentId);
}
//
students.value.data_type = 'select';
getStudents();

teachers.value.data_type = 'select';
getTeachers();

</script>
<template>
    <!-- Radios list -->
    <div class="row px-0 mx-0">
        <div class="col-md-4 mb-4">
            <div class="bg-white border rounded-16 py-4 px-4 h-100">
                <h6 class="h7 mb-2"><ion-icon name="radio-outline"></ion-icon> <span v-text="trans('School Radio')"></span>
                </h6>
                <p class="p5 mb-4">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل .</p>
                <a href="javascript:;" class="action-box" @click="radioForm.show = !radioForm.show">
                    <div class="action-box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                            <path
                                d="M49.875 28C49.875 28.6962 49.5984 29.3639 49.1062 29.8562C48.6139 30.3484 47.9462 30.625 47.25 30.625H30.625V47.25C30.625 47.9462 30.3484 48.6139 29.8562 49.1062C29.3639 49.5984 28.6962 49.875 28 49.875C27.3038 49.875 26.6361 49.5984 26.1438 49.1062C25.6516 48.6139 25.375 47.9462 25.375 47.25V30.625H8.75C8.05381 30.625 7.38613 30.3484 6.89384 29.8562C6.40156 29.3639 6.125 28.6962 6.125 28C6.125 27.3038 6.40156 26.6361 6.89384 26.1438C7.38613 25.6516 8.05381 25.375 8.75 25.375H25.375V8.75C25.375 8.05381 25.6516 7.38613 26.1438 6.89384C26.6361 6.40156 27.3038 6.125 28 6.125C28.6962 6.125 29.3639 6.40156 29.8562 6.89384C30.3484 7.38613 30.625 8.05381 30.625 8.75V25.375H47.25C47.9462 25.375 48.6139 25.6516 49.1062 26.1438C49.5984 26.6361 49.875 27.3038 49.875 28Z"
                                fill="#667080" fill-opacity="0.1" />
                        </svg>
                    </div>
                    <p class="p5 mb-0" v-text="trans('Create your school radio')"></p>
                </a>
            </div>
        </div>

        <!-- Waiting for radios response (Loading) -->
        <template v-if="!radios.response">
            <div class="text-center">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </template>

        <!-- If request failed -->
        <template v-else-if="radios.response.status != 200">
            <div class="text-center text-danger" v-text="radios.response.data.message || radios.response.statusText"></div>
        </template>

        <!-- If no radios data -->
        <template v-else-if="radios.list.length == 0">
            <div class="text-center">{{ trans('No Data') }}</div>
        </template>

        <!-- else Show radios list -->
        <template v-else>
            <div class="col-md-4 mb-4" v-for="radio in radios.list">
                <div class="radio-box bg-white border rounded-16 h-100 overlay-actions-parent">
                    <div class="bg-image">
                        <div class="bg-image-holder">
                            <img :src="radio.bgImage.pathUrl" :alt="radio.name">
                        </div>
                    </div>
                    <div class="radio-info px-4 pt-3">
                        <h6 class="h9 radio-title mb-1">
                            <ion-icon name="radio-outline"></ion-icon> <span v-text="radio.name"></span>
                        </h6>
                        <div class="mb-3 text-secondary">
                            <span v-text="radio.radioDateFormated"></span>
                        </div>
                        <div>
                            <b v-text="trans('Participating students') + ': '"></b>
                            {{ radio.students.map(student => student.name).join(', ') }}
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center py-3 px-2" style="gap: 0.7rem; position: sticky;top: 100%;">
                        <div>
                            <ion-icon name="person-outline" class="me-2"></ion-icon>
                            <span v-text="radio.teacher.name"></span>
                        </div>
                        <div>
                            <ion-icon name="bookmark-outline" class="me-2"></ion-icon>
                            <span v-text="trans('Class') + ' ' +radio.class"></span>
                        </div>
                    </div>
                    <div class="overlay-actions">
                        <button type="button" class="button secondary-button me-2"
                            @click="editRadio(radio)"><ion-icon name="eye-outline"></ion-icon></button>
                        <button type="button" class="primary-button me-2" @click="editRadio(radio)"><ion-icon
                                name="create-outline"></ion-icon></button>
                        <button type="button" @click="deleteRadio(radio)" class="button button-red"><ion-icon
                                name="trash-outline"></ion-icon></button>
                    </div>
                </div>
            </div>
        </template>
        <template v-if="radios.isProccessing && radios.response">
            <div class="is-proccessing">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </template>
    </div>

    <MainPaginationComponent v-if="radios.list.length" :meta="radios.response.data.meta" @updateList="getRadios" />

    <!-- Create radio form -->
    <MainModalComponent v-if="radioForm.show" @closeModal="closeModal()" :class="{ 'w-800px': true }">
        <div class="p-5 px-4">
            <form @submit.prevent="createRadio()">

                <div class="row">
                    <div class="mb-3 col-12">
                        <InputComponent :errors="radioForm.errors.bg_image" path="radio-bgs" type="file"
                            v-model='radioForm.data.bg_image' @onFileUpload="onBgUpload"
                            :help="trans('ضع صورة لغلاف الإذاعة')">
                            <template #customLabel>
                                <div class="image_">
                                    <div class="image_-holder">
                                        <div v-if="!radioBgImage" class="img_replacer">
                                            <i class="iconsax" icon-name="picture-no-square">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    style="width: 54px;height: 54px;" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M21.6799 16.9599L18.5499 9.64988C17.4899 7.16988 15.5399 7.06988 14.2299 9.42988L12.3399 12.8399C11.3799 14.5699 9.58993 14.7199 8.34993 13.1699L8.12993 12.8899C6.83993 11.2699 5.01993 11.4699 4.08993 13.3199L2.36993 16.7699C1.15993 19.1699 2.90993 21.9999 5.58993 21.9999H18.3499C20.9499 21.9999 22.6999 19.3499 21.6799 16.9599Z"
                                                        stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" fill="#667080"
                                                        style="fill: #667080; stroke: #667080;"></path>
                                                    <path
                                                        d="M6.96997 8C8.62682 8 9.96997 6.65685 9.96997 5C9.96997 3.34315 8.62682 2 6.96997 2C5.31312 2 3.96997 3.34315 3.96997 5C3.96997 6.65685 5.31312 8 6.96997 8Z"
                                                        stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" style="fill: #667080; stroke: #667080;">
                                                    </path>
                                                </svg>
                                            </i>
                                        </div>
                                        <img v-else :src="radioBgImage.pathUrl">
                                    </div>
                                </div>
                            </template>
                        </InputComponent>


                        <ul class="invalid-feedback" v-if="radioForm.errors.bg_image">
                            <li v-text="error" v-for="error in radioForm.errors.bg_image">
                            </li>
                        </ul>
                    </div>
                    <InputComponent class="col-md-12" :errors="radioForm.errors.name"
                        label='<ion-icon name="radio"></ion-icon>' placeholder="Radio name" v-model='radioForm.data.name'
                        :required="true" />

                    <InputComponent class="col-md-6" type="date" :errors="radioForm.errors.radio_date"
                        label='<ion-icon name="calendar"></ion-icon>' placeholder="Radio date"
                        v-model='radioForm.data.radio_date' :required="true" />

                    <InputComponent class="col-md-6" :errors="radioForm.errors.class"
                        label='<ion-icon name="bookmark"></ion-icon>' placeholder="Class" v-model='radioForm.data.class'
                        :required="true" />

                    <InputComponent class="col-md-12" type="select" :searchable="true"
                        label='<ion-icon name="person"></ion-icon>' placeholder="Class leader"
                        :errors="radioForm.errors.teacher_id" v-model="radioForm.data.teacher_id" :options="teachers.list"
                        :required="true" />

                    <InputComponent class="col-md-12" type="select" :isModel="false" :searchable="true"
                        label='<ion-icon name="school"></ion-icon>' placeholder="Participating students"
                        :errors="radioForm.errors.students" @onChange="onSelectAddStudent" :options="studentsList"
                        :required="true" />

                    <ul class="d-flex flex-wrap list-unstyled">
                        <li v-for="studentId in radioForm.data.students" @click="onSelectDeleteStudent(studentId)"
                            class="bg-light p-2 me-2 mb-2 rounded-16"><span v-text="students.list[studentId] || trans('Unknown')"></span></li>
                    </ul>
                </div>


                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="radioForm.processing">
                        {{ radioForm.processing ? trans('Please wait') : (
                            radioForm.update ? trans('Update') : trans('Save')
                        ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{ trans('Close') }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
