<script setup>
import { watchEffect, inject, ref } from 'vue';
import useTeachers from '../services/teachers-service.js'
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';

const trans = inject('trans');

const { teachers, getTeachers, getTeacher, storeTeacher, teacherForm, destroyTeacher, importTeacherForm, importTeachers } = useTeachers()

const createTeacher = async () => {
    await storeTeacher();

    if(teacherForm.value.response.status == 200 && !teacherForm.value.update) {
        teacherForm.value.show = false;
    }
}
const editTeacher = async (teacher) => {
    teachers.value.isProccessing = true
    teacher = await getTeacher(teacher.id)
    teachers.value.isProccessing = false
    if(!teacher) return;

    teachers.value.list = teachers.value.list.map((techRec) => techRec.id == teacher.id ? teacher : techRec)

    teacherForm.value.show = true
    teacherForm.value.data = {name: teacher.name, email: teacher.email, phone_number: teacher.phoneNumber}

    teacherForm.value.update = teacher
}

const closeModal = () => {
    teacherForm.value.show = false
    teacherForm.value.errors = []
}

const closeImportModal = () => {
    importTeacherForm.value.show = false
    importTeacherForm.value.errors = []
}

const handleExcelFileChange = (event) => {
    importTeacherForm.value.data.file = event.target.files.length > 0 ? event.target.files[0] : null;
}
watchEffect(() => {
    if(!teacherForm.value.show) {
        teacherForm.value.response = null
        teacherForm.value.errors = []
        if(teacherForm.value.update) {
            teacherForm.value.data = teacherForm.value.defaultData;
            teacherForm.value.update = null
        }

    }
})

const deleteTeacher = (teacher) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroyTeacher(teacher)
}


getTeachers()

const searchTiemout = ref(null);

const onSearch = (event) => {
    if(searchTiemout.value) {
        clearTimeout(searchTiemout.value)
    }

    teachers.value.search = event.target.value;
    searchTiemout.value = setTimeout(() => {
        getTeachers();
    }, 600)
}
</script>
<template>
    <!-- Teachers list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between">
                <h6 class="h7" v-text="trans('Teachers')"></h6>
                <input type="text"
                        class="form-control mb-2" style="max-width: 300px;" :placeholder="trans('Search')" @keyup="onSearch($event)">
                <div class="text-end">
                    <button class="button bg-primary mb-2 me-2" @click="importTeacherForm.show = !importTeacherForm.show">
                        <ion-icon name="cloud-upload-outline"></ion-icon> {{ trans('Import teachers') }}
                    </button>
                    <button class="primary-button" @click="teacherForm.show = !teacherForm.show">
                        {{ trans('Add new teacher') }}
                    </button>
                </div>
            </div>
            <p class="p5 mb-4">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل .</p>
        </template>

        <!-- Card Body -->
        <div>
            <!-- Waiting for teachers response (Loading) -->
            <template v-if="!teachers.response">
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
            <template v-else-if="teachers.response.status != 200">
                <div class="text-center text-danger"
                    v-text="teachers.response.data.message || teachers.response.statusText"></div>
            </template>

            <!-- If no teachers data -->
            <template v-else-if="teachers.list.length == 0">
                <div class="text-center">{{ trans('No Data') }}</div>
            </template>

            <!-- else Show teachers list -->
            <template v-else>
                <MainTableComponent>
                    <template #thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Teacher name') }}</th>
                            <th>{{ trans('Official email') }}</th>
                            <th>{{ trans('Phone number') }}</th>
                            <th>{{ trans('Operations') }}</th>
                        </tr>
                    </template>
                    <tr v-for="teacher in teachers.list">
                        <td scope="row" v-text="teacher.id"></td>
                        <td v-text="teacher.name"></td>
                        <td><a :href="'mailto:'+teacher.email" v-text="teacher.email"></a></td>
                        <td>
                            <a v-if="teacher.phoneNumber" :href="'tel:'+teacher.phoneNumber" v-text="teacher.phoneNumber" dir="ltr"></a>
                            <template v-else>{{ trans('Not included') }}</template>
                        </td>
                        <td class="d-flex">
                            <button type="button" class="primary-button p-0 px-2 me-2" @click="editTeacher(teacher)"><ion-icon
                                    name="create-outline"></ion-icon></button>
                            <button type="button" @click="deleteTeacher(teacher)"
                                class="button button-red p-0 px-2"><ion-icon name="trash-outline"></ion-icon></button>
                        </td>
                    </tr>
                </MainTableComponent>

                <MainPaginationComponent :meta="teachers.response.data.meta" @updateList="getTeachers" />
            </template>
            <template v-if="teachers.isProccessing && teachers.response">
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
    </MainCardComponent>

    <!-- Create teacher form -->
    <MainModalComponent v-if="teacherForm.show" @closeModal="closeModal()" :class="{'w-1000px': true}">
        <div class="p-5 px-4">
            <form @submit.prevent="createTeacher()">

                <h6 class="h9 border-bottom pb-3 mb-4" v-text="trans('Teacher information')"></h6>
                <div class="row">
                    <InputComponent class="col-md-6" :errors="teacherForm.errors.name" label='<ion-icon name="person"></ion-icon>' placeholder="Teacher name" v-model='teacherForm.data.name' :required="true" />

                    <InputComponent class="col-md-6" type="email" :errors="teacherForm.errors.email" label='<ion-icon name="mail"></ion-icon>' placeholder="Official email" v-model='teacherForm.data.email' :required="true" />

                    <InputComponent class="col-md-6" :errors="teacherForm.errors.phone_number" label='<ion-icon name="call"></ion-icon>' placeholder="Phone number" v-model='teacherForm.data.phone_number' dir="ltr" :required="true" />

                </div>


                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="teacherForm.processing">
                        {{ teacherForm.processing ? trans('Please wait') : (
                            teacherForm.update ? trans('Update') : trans('Save')
                        ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{
                            trans('Close')
                    }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>

    <!-- Import teachers form -->
    <MainModalComponent v-if="importTeacherForm.show" @closeModal="closeImportModal()" :class="{'w-1000px': true}">
        <div class="p-5 px-4">
            <form @submit.prevent="importTeachers()">
                <div class="mb-3 col-12">
                    <div class="mb-3">
                        <label for="file" class="form-label" v-text="trans('Excel file')"></label>
                        <input
                            type="file"
                            class="form-control"
                            @change="handleExcelFileChange($event)"
                            id="file"
                            :placeholder="trans('Excel file')"
                            accept=".xlsx, .xls"
                            required
                        />
                    </div>

                </div>
                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="importTeacherForm.processing">
                        {{ importTeacherForm.processing ? trans('Please wait') + ' (' + importTeacherForm.process.percent + '%)' : trans('Import') }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeImportModal()">{{
                            trans('Close')
                    }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
