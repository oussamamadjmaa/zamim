<script setup>
import { watchEffect, inject, watch, computed, ref } from 'vue';
import useRadios from '../services/radios-service.js'
import useStudents from '../services/students-service.js'
import useTeachers from '../services/teachers-service.js'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue';

const trans = inject('trans');
const selectedSemesterName = ref('Unknown');

const { radios, getRadios, getRadio, storeRadio, radioForm } = useRadios()
const { students, getStudents } = useStudents()
const { teachers, getTeachers } = useTeachers()

const createRadio = async () => {
    await storeRadio();

    if (radioForm.value.response.status == 200 && !radioForm.value.update) {
        radioForm.value.show = false;
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
    radioForm.value.data = { name: radio.name, class: radio.class, radio_date: radio.radioDate, teacher_id: radio.teacher.id, students: studentsIds }

    radioForm.value.update = radio
}

const closeModal = () => {
    radioForm.value.show = false
    radioForm.value.errors = []
}

const filteredRadios = (week) => {
    let filteredRadios = radios.value.list.filter(radio => radio.semesterId === parseInt(week.semesterId) && radio.level == week.level && radio.weekNumber === parseInt(week.weekNumber));
    radios.value.response.data.weeks[`${week.semesterId}-${week.level}-${week.weekNumber}`].show = filteredRadios.length;

    return filteredRadios.sort((a, b) => new Date(a.radioDate) - new Date(b.radioDate));
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



const onSelectAddStudent = (studentId) => {
    radioForm.value.data.students = [...radioForm.value.data.students, parseInt(studentId)]
}

const onSelectDeleteStudent = (studentId) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    radioForm.value.data.students = radioForm.value.data.students.filter(sId => sId != studentId);
}

watch(radios.value.extraParams, async (newVal) => {
    await getRadios();

    if (radios.value.response?.data) {
        let semesterId = radios.value.extraParams.semester_id;
        let semester = radios.value.response.data.semesters.filter(semester => semester.id == semesterId)[0] ?? [];

        selectedSemesterName.value = semester ? semester.name + ' ('+ semester.startDateHijri + ' - ' + semester.endDateHijri +')' : trans('Unknown');
    }
}, { deep: true });
//
radios.value.extraParams.semester_id = window._app.currentSemester.id
getRadios();

students.value.dataType = 'select';
getStudents();

teachers.value.dataType = 'select';
getTeachers();

</script>
<template>
    <!-- Radios list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between mb-4">
                <h6 class="h7 mb-2"><ion-icon name="radio-outline"></ion-icon> <span
                        v-text="trans('School Radio')"></span>
                </h6>
            </div>

            <div class="mb-4 d-flex">
                <template
                    v-if="radios.response && radios.response.status == 200 && radios.response.data.semesters.length">
                    <div class="dropdown ms-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="filterLevel"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            v-text="trans('Semester') + ' ('+ selectedSemesterName +')'">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="filterLevel">
                            <a v-for="semester in radios.response.data.semesters" :class="{'dropdown-item': true, 'active': radios.extraParams.semester_id == semester.id}"
                                href="javascript:;" v-on:click="radios.extraParams.semester_id = semester.id"
                                v-text="semester.name + ' ('+ semester.startDateHijri + ' - ' + semester.endDateHijri +')'"></a>


                        </div>
                    </div>
                </template>
            </div>
        </template>
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
            <div class="text-center text-danger" v-text="radios.response.data.message || radios.response.statusText">
            </div>
        </template>

        <!-- If no radios data -->
        <template v-else-if="radios.list.length == 0">
            <div class="text-center">{{ trans('No Data') }}</div>
        </template>

        <!-- else Show radios list -->
        <template v-else>
            <div class="row px-0 mx-0">
                <div class="col-md-6" v-for="(week, weekNumber) in radios.response.data.weeks" :key="weekNumber"
                    v-show="week.show">
                    <div class="mx-3">
                        <table class="table weekly-radios-table">
                            <thead>
                                <tr>
                                    <th colspan="4" v-text="week.title + ' (' + week.weekRangeHijri + ')'">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="radio in filteredRadios(week)">
                                    <td scope="row" v-text="radio.radioDay"></td>
                                    <td v-text="radio.radioDateHijri"></td>
                                    <td v-text="radio.subject"></td>
                                    <td>
                                        <button type="button" class="button secondary-button py-1 px-2 me-2"
                                            @click="editRadio(radio)"><ion-icon name="eye-outline"></ion-icon></button>
                                        <button type="button" class="primary-button me-2 py-1 px-2"
                                            @click="editRadio(radio)"><ion-icon
                                                name="create-outline"></ion-icon></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    </MainCardComponent>
    <!-- Create radio form -->
    <MainModalComponent v-if="radioForm.show" @closeModal="closeModal()" :class="{ 'w-800px': true }">
        <div class="p-5 px-4">
            <form @submit.prevent="createRadio()">

                <div class="row">
                    <InputComponent class="col-md-6" type="date" :errors="radioForm.errors.radio_date"
                        label='<ion-icon name="calendar"></ion-icon>' placeholder="Radio date"
                        v-model='radioForm.data.radio_date' :minDate="_app.currentSemester.startDate || null"
                        :maxDate="_app.currentSemester.endDate || null" :required="true" />

                    <InputComponent class="col-md-6" :errors="radioForm.errors.class"
                        label='<ion-icon name="bookmark"></ion-icon>' placeholder="Class" v-model='radioForm.data.class'
                        :required="true" />

                    <InputComponent class="col-md-12" type="select" :searchable="true"
                        label='<ion-icon name="person"></ion-icon>' placeholder="Class leader"
                        :errors="radioForm.errors.teacher_id" v-model="radioForm.data.teacher_id"
                        :options="teachers.list" :required="true" />

                    <InputComponent class="col-md-12" type="select" :isModel="false" :searchable="true"
                        label='<ion-icon name="school"></ion-icon>' placeholder="Participating students"
                        :errors="radioForm.errors.students" @onChange="onSelectAddStudent" :options="studentsList"
                        :required="true" />

                    <ul class="d-flex flex-wrap list-unstyled">
                        <li v-for="studentId in radioForm.data.students" @click="onSelectDeleteStudent(studentId)"
                            class="bg-light p-2 me-2 mb-2 rounded-16"><span
                                v-text="students.list[studentId] || trans('Unknown')"></span></li>
                    </ul>
                </div>


                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="radioForm.processing">
                        {{ radioForm.processing ? trans('Please wait') : (
                            radioForm.update ? trans('Update') : trans('Save')
                        ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{ trans('Close')
                        }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
