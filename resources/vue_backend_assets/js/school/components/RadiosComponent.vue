<script setup>
import { inject, watch, computed } from 'vue';
import useRadios from '../services/radios-service.js'
import useStudents from '../services/students-service.js'
import useTeachers from '../services/teachers-service.js'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue';

// Inject
const trans = inject('trans');

// Services
const { radios, getRadios, getRadio, storeRadio, radioForm, storeRating, pageUrl } = useRadios()
const { students, getStudents } = useStudents()
const { teachers, getTeachers } = useTeachers()


// Vars
const stars = Array(5).fill(0);

// API Actions
const createRadio = async () => {
    await storeRadio();

    if (radioForm.value.response.status == 200 && radioForm.value.response.data.data) {
        radioForm.value.update = radioForm.value.response.data.data;
    }
}

// API Actions
const doRating = async () => {
    const res = await storeRating(`${pageUrl}/${radioForm.value.update.id}/rating`);

    if (res.response.status == 200 && res.response.data.data) {
        res.update = res.response.data.data;
    }
}

const editRadio = async (radio, rating = false) => {
    radios.value.isProccessing = true
    radio = await getRadio(radio.id)
    radios.value.isProccessing = false

    if (!radio) return;

    radioForm.value.rating = rating
    radioForm.value.update = radio
    radioForm.value.show = true
}

// Actions
const closeModal = () => {
    radioForm.value.show = false
    radioForm.value.errors = []
}

const onSelectAddStudent = (studentId) => {
    studentId = parseInt(studentId);
    if (!studentId) return;

    radioForm.value.data.students.push({ student_id: studentId, article_id: null, article: {} });
}

const onSelectDeleteStudent = (key) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    radioForm.value.data.students.splice(key, 1);
}

const toggleChannel = (channel) => {
    if (radioForm.value.data.notification_channels.includes(channel)) {
        radioForm.value.data.notification_channels = radioForm.value.data.notification_channels.filter(item => item !== channel);
    } else {
        radioForm.value.data.notification_channels.push(channel);
    }
}

// Filters
const filteredRadios = (week) => {
    let filteredRadios = radios.value.list.filter(radio => radio.semesterId === parseInt(week.semesterId) && radio.level == week.level && radio.weekNumber === parseInt(week.weekNumber));
    radios.value.response.data.weeks[`${week.semesterId}-${week.level}-${week.weekNumber}`].show = filteredRadios.length;

    return filteredRadios.sort((a, b) => new Date(a.radioDate) - new Date(b.radioDate));
}

// Computed
const studentsList = computed(() => {
    const selectedStudentIds = Object.values(radioForm.value.data.students).map(student => student.student_id);
    const filteredStudents = [];


    for (const studentId in students.value.list) {
        if (!selectedStudentIds.includes(parseInt(studentId))) {
            filteredStudents[studentId] = students.value.list[studentId];
        }
    }

    return filteredStudents;
})

const selectedSemesterName = computed(() => {
    let semester = radios.value.response.data.semesters.find(semester => semester.id == radios.value.extraParams.semester_id) || {};

    return semester ? semester.name + ' (' + semester.startDateHijri + ' - ' + semester.endDateHijri + ')' : trans('Unknown');
});

// Watches
watch(() => radioForm.value.show, (show) => {
    if (!show) {
        radioForm.value.response = null
        radioForm.value.errors = []

        if (radioForm.value.update) {
            radioForm.value.data = radioForm.value.defaultData;
            radioForm.value.update = null
        }
    }
})

watch(() => radioForm.value.update, (radio) => {
    if (radio) {
        const data = {
            students: [],
            notification_channels: []
        };

        if (radioForm.value.rating) {
            data.teacher_rating = parseInt(radio.teacher?.pivot?.rating || 0);
            data.students = radio.students.map(student => ({
                student_id: student.id,
                rating: parseInt(student.pivot.rating || 0)
            }));
        } else {
            data.teacher_id = parseInt(radio.teacher?.id || null);
            data.students = radio.students.map(student => ({
                student_id: student.id,
                article_id: student.pivot.article_id,
                article: {}
            }));
        }

        radioForm.value.data = data;

        radios.value.list = radios.value.list.map(rad => rad.id === radio.id ? radio : rad);
    }
})


watch(radios.value.extraParams, async (newVal) => {
    await getRadios();
}, { deep: true });

// Initial fetches
radios.value.extraParams.semester_id = window._app.currentSemester.id


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
                            v-text="trans('Semester') + ' (' + selectedSemesterName + ')'">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="filterLevel">
                            <a v-for="semester in radios.response.data.semesters" :key="semester.id"
                                :class="{ 'dropdown-item': true, 'active': radios.extraParams.semester_id == semester.id }"
                                href="javascript:;" v-on:click="radios.extraParams.semester_id = semester.id"
                                v-text="semester.name + ' (' + semester.startDateHijri + ' - ' + semester.endDateHijri + ')'"></a>


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
            <div class="row px-0 mx-0" style="overflow: auto;">
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
                                <tr v-for="radio in filteredRadios(week)" :key="radio.id">
                                    <td scope="row" v-text="radio.radioDay"></td>
                                    <td v-text="radio.radioDateHijri"></td>
                                    <td v-text="radio.subject"></td>
                                    <td>
                                        <button v-if="!radio.hasCurrentSchool" type="button"
                                            class="button bg-info py-1 px-2 me-2" @click="editRadio(radio)"
                                            v-text="trans('Subscribe')"></button>
                                        <template v-else>
                                            <button type="button" class="primary-button me-2 py-1 px-2"
                                                @click="editRadio(radio)" :title="trans('Edit')"><ion-icon
                                                    name="create-outline"></ion-icon></button>
                                            <button type="button" class="secondary-button me-2 py-1 px-2"
                                                @click="editRadio(radio, true)" :title="trans('Rating')"><ion-icon
                                                    name="star-outline"></ion-icon></button>
                                        </template>
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
            <form @submit.prevent="radioForm.rating ? doRating() : createRadio()">
                <div class="row">
                    <h6 class="h9 border-bottom pb-3 mb-4 col-12" v-text="trans('Radio information')"></h6>
                    <ul class="list-unstyled">
                        <li>
                            <b v-text="trans('Subject') + ': '"></b>
                            <span v-text="radioForm.update.subject"></span>
                        </li>
                        <li>
                            <b v-text="trans('Radio date') + ': '"></b>
                            <span
                                v-text="radioForm.update.radioDateHijriFormated + ' (' + trans('Week') + ' ' + radioForm.update.weekNumber + ')'"></span>
                        </li>
                        <li>
                            <b v-text="trans('Semester') + ': '"></b>
                            <span v-text="selectedSemesterName"></span>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <h6 class="h9 border-bottom pb-3 mb-4 col-12" v-text="trans('Class leader')"></h6>
                    <div>
                        <InputComponent v-if="!radioForm.rating" class="col-md-12" type="select" :searchable="true"
                            label='<ion-icon name="person"></ion-icon>' placeholder="Class leader"
                            :errors="radioForm.errors.teacher_id" v-model="radioForm.data.teacher_id"
                            :options="teachers.list" :required="true" />

                        <InputComponent v-else class="col-md-12" label='<ion-icon name="person"></ion-icon>'
                            :readonly="true" :modelValue="teachers.list[radioForm.update.teacher.id]" />

                        <template v-if="radioForm.rating">
                            <div class="col-12">
                                <h5 class="text-center" v-text="trans('Class leader performance evaluation')"></h5>

                                <div class="star-rating text-center" style="font-size: 39px;">
                                    <span v-for="(star, index) in stars" :key="index"
                                        @click="radioForm.data.teacher_rating = (index + 1)"
                                        :class="{ 'filled': index < radioForm.data.teacher_rating }">&#9733;</span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <h6 class="h9 border-bottom pb-3 my-4 col-12" v-text="trans('Participating students')"></h6>
                    <InputComponent v-if="!radioForm.rating" class="col-md-12" type="select" :isModel="false"
                        :searchable="true" label='<ion-icon name="school"></ion-icon>'
                        placeholder="Participating students" :errors="radioForm.errors.students"
                        @onChange="onSelectAddStudent" :options="studentsList" :required="true" />


                    <ul class="list-unstyled">
                        <li v-for="(val, key) in radioForm.data.students" :key="val.student_id"
                            class="border p-2 rounded mb-2">
                            <a v-if="!radioForm.rating" href="#" @click="onSelectDeleteStudent(key)"
                                class="text-danger mb-2 d-block" v-text="trans('Delete')"></a>
                            <div class="row mx-0">
                                <InputComponent class="col-md-6" label='<ion-icon name="person"></ion-icon>'
                                    :readonly="true" :modelValue="students.list[val.student_id]" />

                                <template v-if="radioForm.rating">
                                    <InputComponent class="col-md-6" label='<ion-icon name="bookmark"></ion-icon>'
                                        :readonly="true"
                                        :modelValue="radioForm.update.articles.find((art) => art.id == radioForm.update.students.find((std) => std.pivot.student_id == val.student_id).pivot.article_id)['title']" />

                                    <div class="col-12">
                                        <h5 class="text-center mt-3 mb-1"
                                            v-text="trans('Student performance evaluation')"></h5>

                                        <div class="star-rating text-center" style="font-size: 39px;">
                                            <span v-for="(star, index) in stars" :key="index"
                                                @click="val.rating = (index + 1)"
                                                :class="{ 'filled': index < val.rating }">&#9733;</span>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <InputComponent class="col-md-6" type="select" :searchable="true"
                                        :object="{ key: 'id', value: 'title' }"
                                        label='<ion-icon name="bookmark"></ion-icon>' placeholder="Article"
                                        :errors="radioForm.errors['students.' + key + '.article'] || radioForm.errors['students.' + key + '.article.article_id']"
                                        v-model="val.article_id" :options="radioForm.update.articles"
                                        :preOptions="[{ 'id': '', 'title': trans('Add new article') }]"
                                        :required="true" />

                                    <template v-if="val.article_id == ''">
                                        <div class="px-0">
                                            <div class="row mx-0">
                                                <InputComponent class="col-md-6"
                                                    label='<ion-icon name="bookmark"></ion-icon>'
                                                    placeholder="Article title" v-model='val.article.title'
                                                    :errors="radioForm.errors['students.' + key + '.article.title']"
                                                    :required="true" />

                                                <InputComponent class="col-md-6" type="select" :searchable="true"
                                                    label='<ion-icon name="globe"></ion-icon>'
                                                    placeholder="Share article"
                                                    :errors="radioForm.errors['students.' + key + '.article.is_public']"
                                                    v-model="val.article.is_public"
                                                    :options="{ '1': trans('Yes'), '0': trans('No') }"
                                                    :required="true" />
                                            </div>

                                            <InputComponent type="file"
                                                :errors="radioForm.errors['students.' + key + '.article.attachment']"
                                                label='<ion-icon name="file"></ion-icon>'
                                                placeholder="Article attachment" v-model='val.article.attachment'
                                                @onFileUpload="(data, file) => {
                            val.article.attachmentInfo = { data, file };
                        }" path="article-attachments" :required="!val.article.attachment">
                                                <template #customLabel>
                                                    <div class="custom-file-label">
                                                        <span
                                                            v-text="trans((!val.article.attachment) ? 'Select article attachment' : 'Change article attachment')"></span>
                                                    </div>
                                                </template>
                                            </InputComponent>


                                            <div v-if="val.article.attachmentInfo" class="file-upload-progress">
                                                <ion-icon name="attach-outline"></ion-icon>
                                                <span>(100%) {{ val.article.attachmentInfo.file.name }}</span>
                                                <div class="progress" :style="{ 'width': '100%' }"></div>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </li>
                    </ul>
                </div>


                <template v-if="!radioForm.update.hasCurrentSchool">
                    <h6 class="h9 border-bottom pb-3 my-4 col-12" v-text="trans('Notify parents')"></h6>
                    <div>
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input me-2"
                                :checked="radioForm.data.notification_channels.includes('mail')"
                                @change="toggleChannel('mail')">
                            <span v-text="trans('Via email')"></span>
                        </label>
                    </div>
                    <div>
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input me-2"
                                :checked="radioForm.data.notification_channels.includes('whatsapp')"
                                @change="toggleChannel('whatsapp')"> <span v-text="trans('Via Whatsapp')"></span>
                        </label>
                    </div>
                </template>
                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="radioForm.processing">
                        {{ radioForm.processing ? trans('Please wait') : (
                            radioForm.update && radioForm.update.hasCurrentSchool && !radioForm.rating ? trans('Update') : (
                                radioForm.rating ? trans('Save rating') : trans('Subscribe')
                            )
                        ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{ trans('Close')
                        }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
