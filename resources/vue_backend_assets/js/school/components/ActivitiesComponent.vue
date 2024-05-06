<script setup>
import { watchEffect, inject, ref, computed } from 'vue';
import useActivities from '../services/activities-service.js'
import useStudents from '../services/students-service.js'
import useTeachers from '../services/teachers-service.js'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';

const trans = inject('trans');

const { activities, getActivities, getActivity, storeActivity, activityForm, destroyActivity } = useActivities()
const { students, getStudents } = useStudents()
const { teachers, getTeachers } = useTeachers()

const createActivity = async () => {
    await storeActivity();

    if (activityForm.value.response.status == 200 && !activityForm.value.update) {
        activityForm.value.show = false;
        activityBgImage.value = null;
    }
}
const editActivity = async (activity) => {
    activities.value.isProccessing = true
    activity = await getActivity(activity.id)
    activities.value.isProccessing = false
    if (!activity) return;

    activities.value.list = activities.value.list.map((techRec) => techRec.id == activity.id ? activity : techRec)

    activityForm.value.show = true
    const studentsIds = activity.students.map(student => ({student_id: student.id, post_title: student.pivot.post_title}))
    activityForm.value.data = { name: activity.name, class: activity.class, activity_date: activity.activityDate, teacher_id: activity.teacher.id, students: studentsIds, bg_image: activity.bgImage.path }
    activityBgImage.value = activity.bgImage;

    activityForm.value.update = activity
}

const closeModal = () => {
    activityForm.value.show = false
    activityForm.value.errors = []
    activityBgImage.value = null
}

watchEffect(() => {
    if (!activityForm.value.show) {
        activityForm.value.response = null
        activityForm.value.errors = []
        if (activityForm.value.update) {
            activityForm.value.data = activityForm.value.defaultData;
            activityForm.value.update = null
        }

    }
})

const studentsList = computed(() => {
    const result = { ...students.value.list };

    Object.keys(result).forEach((key) => {
        if ((activityForm.value.data.students).hasOwnProperty(parseInt(key))) {
            delete result[key];
        }
    });
    return result;
})

const deleteActivity = (activity) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroyActivity(activity)
}

const activityBgImage = ref(null);
const onBgUpload = (data) => {
    activityBgImage.value = data;
}

getActivities()

const onSelectAddStudent = (studentId) => {
    activityForm.value.data.students[studentId] = {student_id: studentId, post_title:''};
}

const onSelectDeleteStudent = (studentId) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    activityForm.value.data.students = activityForm.value.data.students.filter(sId => sId.student_id != studentId);
}
//
students.value.dataType = 'select';
getStudents();

teachers.value.dataType = 'select';
getTeachers();

const searchTiemout = ref(null);

const onSearch = (event) => {
    if(searchTiemout.value) {
        clearTimeout(searchTiemout.value)
    }

    activities.value.search = event.target.value;
    searchTiemout.value = setTimeout(() => {
        getActivities();
    }, 600)
}

</script>
<template>
    <!-- Activities list -->
    <div class="bg-white border rounded-16 p-4">
        <div>
            <div class="d-flex flex-wrap justify-content-between">
                <h6 class="h7" v-text="trans('Activities')"></h6>
                <input type="text"
                        class="form-control mb-2" style="max-width: 300px;" :placeholder="trans('Search')" @keyup="onSearch($event)">
                <div class="text-end">
                    <button class="primary-button" @click="activityForm.show = !activityForm.show">
                        {{ trans('Add activity') }}
                    </button>
                </div>
            </div>

        </div>
        <!-- Waiting for activities response (Loading) -->
        <template v-if="!activities.response">
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
        <template v-else-if="activities.response.status != 200">
            <div class="text-center text-danger" v-text="activities.response.data.message || activities.response.statusText"></div>
        </template>

        <!-- If no activities data -->
        <template v-else-if="activities.list.length == 0">
            <div class="text-center">{{ trans('No Data') }}</div>
        </template>

        <!-- else Show activities list -->
        <template v-else>
            <div class="col-12 mb-5" v-for="activity in activities.list" :key="activity.id">
                <div class="activity-box">
                    <div class="bg-image me-2">
                        <div class="bg-image-holder">
                            <img :src="activity.bgImage.pathUrl" :alt="activity.name">
                        </div>
                    </div>
                    <div class="activity-info">
                        <div>
                            <h6 class="h9 activity-title mb-1 me-2 d-inline">
                                <span v-text="activity.name"></span>
                            </h6>
                            <small class="text-secondary" v-text="activity.activityDateFormated"></small>
                        </div>
                        <div>
                            <ion-icon name="people-outline" class="me-2"></ion-icon>
                            {{ activity.students.map(student => student.name).join(', ') }}
                        </div>
                        <div class="d-flex flex-wrap" style="gap: 0.7rem;">
                            <div>
                                <ion-icon name="person-outline" class="me-2"></ion-icon>
                                <span v-text="activity.teacher.name"></span>
                            </div>
                            <div>
                                <ion-icon name="bookmark-outline" class="me-2"></ion-icon>
                                <span v-text="trans('Class') + ' ' +activity.class"></span>
                            </div>
                        </div>

                        <div class="actions mt-3">
                            <button type="button" class="secondary-button me-1" @click="editActivity(activity)">عرض التفاصيل</button>
                            <button type="button" class="primary-button me-1" @click="editActivity(activity)"><ion-icon
                                    name="create-outline"></ion-icon></button>
                            <button type="button" @click="deleteActivity(activity)" class="button button-red"><ion-icon
                                    name="trash-outline"></ion-icon></button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-if="activities.isProccessing && activities.response">
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

    <MainPaginationComponent v-if="activities.list.length" :meta="activities.response.data.meta" @updateList="getActivities" />

    <!-- Create activity form -->
    <MainModalComponent v-if="activityForm.show" @closeModal="closeModal()" :class="{ 'w-800px': true }">
        <div class="p-5 px-4">
            <form @submit.prevent="createActivity()">

                <div class="row">
                    <div class="mb-3 col-12">
                        <InputComponent :errors="activityForm.errors.bg_image" path="activity-bgs" type="file"
                            v-model='activityForm.data.bg_image' @onFileUpload="onBgUpload"
                            :help="trans('ضع صورة لغلاف النشاط')">
                            <template #customLabel>
                                <div class="image_">
                                    <div class="image_-holder">
                                        <div v-if="!activityBgImage" class="img_replacer">
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
                                        <img v-else :src="activityBgImage.pathUrl">
                                    </div>
                                </div>
                            </template>
                        </InputComponent>


                        <ul class="invalid-feedback" v-if="activityForm.errors.bg_image">
                            <li v-text="error" v-for="error in activityForm.errors.bg_image">
                            </li>
                        </ul>
                    </div>
                    <InputComponent class="col-md-12" :errors="activityForm.errors.name"
                        label='<ion-icon name="activity"></ion-icon>' placeholder="Activity name" v-model='activityForm.data.name'
                        :required="true" />

                    <InputComponent class="col-md-6" type="date" :errors="activityForm.errors.activity_date"
                        label='<ion-icon name="calendar"></ion-icon>' placeholder="Activity date"
                        v-model='activityForm.data.activity_date' :required="true" />

                    <InputComponent class="col-md-6" :errors="activityForm.errors.class"
                        label='<ion-icon name="bookmark"></ion-icon>' placeholder="Class" v-model='activityForm.data.class'
                        :required="true" />

                    <InputComponent class="col-md-12" type="select" :searchable="true"
                        label='<ion-icon name="person"></ion-icon>' placeholder="Activity leader"
                        :errors="activityForm.errors.teacher_id" v-model="activityForm.data.teacher_id" :options="teachers.list"
                        :required="true" />

                    <InputComponent class="col-md-12" type="select" :isModel="false" :searchable="true"
                        label='<ion-icon name="school"></ion-icon>' placeholder="Participating students"
                        :errors="activityForm.errors.students" @onChange="onSelectAddStudent" :options="studentsList"
                        :required="true" />

                    <ul class="list-unstyled">
                        <li v-for="(val, key) in activityForm.data.students">
                            <div class="row mx-0 ">
                                <InputComponent class="col-md-6" label='<ion-icon name="person"></ion-icon>' :readonly="true" :modelValue="students.list[val.student_id]"/>
                                <InputComponent class="col-md-6" label='<ion-icon name="person"></ion-icon>' placeholder="Post title" v-model="val.post_title" />
                            </div>
                    </li>
                    </ul>
                </div>


                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="activityForm.processing">
                        {{ activityForm.processing ? trans('Please wait') : (
                            activityForm.update ? trans('Update') : trans('Save')
                        ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{ trans('Close') }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
