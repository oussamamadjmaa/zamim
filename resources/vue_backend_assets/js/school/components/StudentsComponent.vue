<script setup>
import { watchEffect, inject, ref } from 'vue';
import useStudents from '../services/students-service.js'
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';

const trans = inject('trans');

const { students, getStudents, getStudent, storeStudent, studentForm, destroyStudent, importStudentForm, importStudents } = useStudents()

const createStudent = async () => {
    await storeStudent();

    if(studentForm.value.response.status == 200 && !studentForm.value.update) {
        studentForm.value.show = false;
    }
}

const editStudent = async (student) => {
    students.value.isProccessing = true
    student = await getStudent(student.id)
    students.value.isProccessing = false
    if(!student) return;

    students.value.list = students.value.list.map((studRec) => studRec.id == student.id ? student : studRec)

    studentForm.value.show = true
    studentForm.value.data = {name: student.name, email: student.email, phone_number: student.phoneNumber, profile: {
        parent_name: student.profile.parentName,
        parent_email: student.profile.parentEmail,
        class: student.profile.class,
        division: student.profile.division,
    }}

    studentForm.value.update = student
}

const closeModal = () => {
    studentForm.value.show = false
    studentForm.value.errors = []
}

const closeImportModal = () => {
    importStudentForm.value.show = false
    importStudentForm.value.errors = []
}

const handleExcelFileChange = (event) => {
    importStudentForm.value.data.file = event.target.files.length > 0 ? event.target.files[0] : null;
}
//
watchEffect(() => {
    if(!studentForm.value.show) {
        studentForm.value.response = null
        studentForm.value.errors = []
        if(studentForm.value.update) {
            studentForm.value.data = studentForm.value.defaultData;
            studentForm.value.update = null
        }

    }

    if(!importStudentForm.value.show) {
        importStudentForm.value.response = null
        importStudentForm.value.errors = []
    }
})

const deleteStudent = (student) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroyStudent(student)
}


getStudents()


const searchTiemout = ref(null);

const onSearch = (event) => {
    if(searchTiemout.value) {
        clearTimeout(searchTiemout.value)
    }

    students.value.search = event.target.value;
    searchTiemout.value = setTimeout(() => {
        getStudents();
    }, 600)
}
</script>
<template>
    <!-- Students list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between mb-4">
                <h6 class="h7" v-text="trans('Students')"></h6>
                <input type="text"
                        class="form-control mb-2" style="max-width: 300px;" :placeholder="trans('Search')" @keyup="onSearch($event)">
                <div class="text-end">
                    <button class="button bg-primary mb-2 me-2" @click="importStudentForm.show = !importStudentForm.show">
                        <ion-icon name="cloud-upload-outline"></ion-icon> {{ trans('Import students') }}
                    </button>
                    <button class="primary-button mb-2" @click="studentForm.show = !studentForm.show">
                        <ion-icon name="add"></ion-icon> {{ trans('Add new student') }}
                    </button>
                </div>
            </div>

        </template>

        <!-- Card Body -->
        <div>
            <!-- Waiting for students response (Loading) -->
            <template v-if="!students.response">
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
            <template v-else-if="students.response.status != 200">
                <div class="text-center text-danger"
                    v-text="students.response.data.message || students.response.statusText"></div>
            </template>

            <!-- If no students data -->
            <template v-else-if="students.list.length == 0">
                <div class="text-center">{{ trans('No Data') }}</div>
            </template>

            <!-- else Show students list -->
            <template v-else>
                <MainTableComponent>
                    <template #thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Student name') }}</th>
                            <th>{{ trans('Official email') }}</th>
                            <th>{{ trans('Guardian name') }}</th>
                            <th>{{ trans('Guardian phone') }}</th>
                            <th>{{ trans('Guardian email') }}</th>
                            <th>{{ trans('Class') }}</th>
                            <th>{{ trans('Division') }}</th>
                            <th>{{ trans('Operations') }}</th>
                        </tr>
                    </template>
                    <tr v-for="student in students.list" :key="student.id">
                        <td scope="row" v-text="student.id"></td>
                        <td v-text="student.name"></td>
                        <td><a :href="'mailto:'+student.email" v-text="student.email"></a></td>
                        <td v-text="student.profile.parentName"></td>
                        <td>
                            <a v-if="student.phoneNumber" :href="'tel:'+student.phoneNumber" v-text="student.phoneNumber" dir="ltr"></a>
                            <template v-else>{{ trans('Not included') }}</template>
                        </td>
                        <td>
                            <a v-if="student.profile.parentEmail" :href="'mailto:'+student.profile.parentEmail" v-text="student.profile.parentEmail" dir="ltr"></a>
                            <template v-else>{{ trans('Not included') }}</template>
                        </td>
                        <td v-text="student.profile.class"></td>
                        <td v-text="student.profile.division"></td>
                        <td class="d-flex">
                            <button type="button" class="primary-button p-0 px-2 me-2" @click="editStudent(student)"><ion-icon
                                    name="create-outline"></ion-icon></button>
                            <button type="button" @click="deleteStudent(student)"
                                class="button button-red p-0 px-2"><ion-icon name="trash-outline"></ion-icon></button>
                        </td>
                    </tr>
                </MainTableComponent>

                <MainPaginationComponent :meta="students.response.data.meta" @updateList="getStudents" />
            </template>
            <template v-if="students.isProccessing && students.response">
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

    <!-- Create student form -->
    <MainModalComponent v-if="studentForm.show" @closeModal="closeModal()" :class="{'w-1000px': true}">
        <div class="p-5 px-4">
            <form @submit.prevent="createStudent()">

                <h6 class="h9 border-bottom pb-3 mb-4" v-text="trans('Student information')"></h6>
                <div class="row">
                    <InputComponent class="col-md-6" :errors="studentForm.errors.name" label='<ion-icon name="person"></ion-icon>' placeholder="Student name" v-model='studentForm.data.name' :required="true" />

                    <InputComponent class="col-md-6" type="email" :errors="studentForm.errors.email" label='<ion-icon name="mail"></ion-icon>' placeholder="Official email" v-model='studentForm.data.email' :required="true" />

                    <InputComponent class="col-md-6" :errors="studentForm.errors['profile.class']" label='<ion-icon name="bookmark"></ion-icon>' placeholder="Class" v-model='studentForm.data.profile.class' :required="true" />

                    <InputComponent class="col-md-6" :errors="studentForm.errors['profile.division']" label='<ion-icon name="bookmark"></ion-icon>' placeholder="Division" v-model='studentForm.data.profile.division' :required="true" />

                </div>

                <h6 class="h9 border-bottom pb-3 mb-4" v-text="trans('Guardian information')"></h6>
                <div class="row">
                    <InputComponent class="col-md-6" :errors="studentForm.errors['profile.parent_name']" label='<ion-icon name="person"></ion-icon>' placeholder="Name" v-model='studentForm.data.profile.parent_name' :required="true" />

                    <InputComponent class="col-md-6" :errors="studentForm.errors.phone_number" label='<ion-icon name="call"></ion-icon>' dir="ltr" placeholder="Guardian phone" v-model='studentForm.data.phone_number' :required="true" />
                    <InputComponent type="email" class="col-md-6" :errors="studentForm.errors['profile.parent_email']" label='<ion-icon name="mail"></ion-icon>' placeholder="Guardian email" v-model='studentForm.data.profile.parent_email'/>
                </div>

                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="studentForm.processing">
                        {{ studentForm.processing ? trans('Please wait') : (
                            studentForm.update ? trans('Update') : trans('Save')
                        ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{
                            trans('Close')
                    }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>

    <!-- Import students form -->
    <MainModalComponent v-if="importStudentForm.show" @closeModal="closeImportModal()" :class="{'w-1000px': true}">
        <div class="p-5 px-4">
            <form @submit.prevent="importStudents()">
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
                    <button type="submit" class="primary-button" :disabled="importStudentForm.processing">
                        {{ importStudentForm.processing ? trans('Please wait') + ' (' + importStudentForm.process.percent + '%)' : trans('Import') }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeImportModal()">{{
                            trans('Close')
                    }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
