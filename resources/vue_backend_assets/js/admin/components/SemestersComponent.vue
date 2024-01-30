<script setup>
import { watchEffect, inject, ref } from 'vue';
import useSemesters from '../services/semesters-service.js'
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';

const trans = inject('trans');

const { semesters, getSemesters, getSemester, storeSemester, semesterForm, destroySemester } = useSemesters()

const createSemester = async () => {
    await storeSemester();

    if(semesterForm.value.response.status == 200 && !semesterForm.value.update) {
        semesterForm.value.show = false;
    }
}
const editSemester = async (semester) => {
    semesters.value.isProccessing = true
    semester = await getSemester(semester.id)
    semesters.value.isProccessing = false
    if(!semester) return;

    semesters.value.list = semesters.value.list.map((techRec) => techRec.id == semester.id ? semester : techRec)

    semesterForm.value.show = true
    semesterForm.value.data = {name: semester.name, start_date: semester.startDate, end_date: semester.endDate}

    semesterForm.value.update = semester
}

const closeModal = () => {
    semesterForm.value.show = false
    semesterForm.value.errors = []
}

watchEffect(() => {
    if(!semesterForm.value.show) {
        semesterForm.value.response = null
        semesterForm.value.errors = []
        if(semesterForm.value.update) {
            semesterForm.value.data = semesterForm.value.defaultData;
            semesterForm.value.update = null
        }

    }
})

const deleteSemester = (semester) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroySemester(semester)
}


getSemesters()

const searchTiemout = ref(null);

const onSearch = (event) => {
    if(searchTiemout.value) {
        clearTimeout(searchTiemout.value)
    }

    semesters.value.search = event.target.value;
    searchTiemout.value = setTimeout(() => {
        getSemesters();
    }, 600)
}
</script>
<template>
    <!-- Semesters list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between">
                <h6 class="h7" v-text="trans('Semesters')"></h6>
                <input type="text"
                        class="form-control mb-2" style="max-width: 300px;" :placeholder="trans('Search')" @keyup="onSearch($event)">
                <div class="text-end">
                    <button class="primary-button" @click="semesterForm.show = !semesterForm.show">
                        {{ trans('Add new semester') }}
                    </button>
                </div>
            </div>
            <p class="p5 mb-4">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل .</p>
        </template>

        <!-- Card Body -->
        <div>
            <!-- Waiting for semesters response (Loading) -->
            <template v-if="!semesters.response">
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
            <template v-else-if="semesters.response.status != 200">
                <div class="text-center text-danger"
                    v-text="semesters.response.data.message || semesters.response.statusText"></div>
            </template>

            <!-- If no semesters data -->
            <template v-else-if="semesters.list.length == 0">
                <div class="text-center">{{ trans('No Data') }}</div>
            </template>

            <!-- else Show semesters list -->
            <template v-else>
                <MainTableComponent>
                    <template #thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Semester name') }}</th>
                            <th>{{ trans('Start date') }}</th>
                            <th>{{ trans('End date') }}</th>
                            <th>{{ trans('Operations') }}</th>
                        </tr>
                    </template>
                    <tr v-for="semester in semesters.list">
                        <td scope="row" v-text="semester.id"></td>
                        <td v-text="semester.name"></td>
                        <td v-text="semester.startDateFormated"></td>
                        <td v-text="semester.endDateFormated"></td>
                        <td class="d-flex">
                            <button type="button" class="primary-button p-0 px-2 me-2" @click="editSemester(semester)"><ion-icon
                                    name="create-outline"></ion-icon></button>
                            <button type="button" @click="deleteSemester(semester)"
                                class="button button-red p-0 px-2"><ion-icon name="trash-outline"></ion-icon></button>
                        </td>
                    </tr>
                </MainTableComponent>

                <MainPaginationComponent :meta="semesters.response.data.meta" @updateList="getSemesters" />
            </template>
            <template v-if="semesters.isProccessing && semesters.response">
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

    <!-- Create semester form -->
    <MainModalComponent v-if="semesterForm.show" @closeModal="closeModal()" :class="{'w-1000px': true}">
        <div class="p-5 px-4">
            <form @submit.prevent="createSemester()">

                <h6 class="h9 border-bottom pb-3 mb-4" v-text="trans('Semester information')"></h6>
                <div class="row">
                    <InputComponent :errors="semesterForm.errors.name" label='<ion-icon name="bookmark"></ion-icon>' placeholder="Semester name" v-model='semesterForm.data.name' :required="true" />

                    <InputComponent class="col-md-6" type="date" :errors="semesterForm.errors.start_date"
                        label='<ion-icon name="calendar"></ion-icon>' placeholder="Start date"
                        v-model='semesterForm.data.start_date' :required="true" />

                    <InputComponent class="col-md-6" type="date" :errors="semesterForm.errors.end_date"
                        label='<ion-icon name="calendar"></ion-icon>' placeholder="End date"
                        v-model='semesterForm.data.end_date' :required="true" />
                </div>


                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="semesterForm.processing">
                        {{ semesterForm.processing ? trans('Please wait') : (
                            semesterForm.update ? trans('Update') : trans('Save')
                        ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{
                            trans('Close')
                    }}</button>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
