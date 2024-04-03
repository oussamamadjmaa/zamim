<script setup>
import { watchEffect, inject, ref } from 'vue';
import useRadioWeeks from '../services/radio-weeks-service.js'
import useSemesters from '../services/semesters-service.js'
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';

const trans = inject('trans');

const { radioWeeks, getRadioWeeks, getRadioWeek, storeRadioWeek, radioWeekForm, destroyRadioWeek } = useRadioWeeks()
const { semesters, getSemesters } = useSemesters()

const createRadioWeek = async () => {
    await storeRadioWeek();

    if(radioWeekForm.value.response.status == 200 && !radioWeekForm.value.update) {
        radioWeekForm.value.show = false;
    }
}
const editRadioWeek = async (radioWeek) => {
    radioWeeks.value.isProccessing = true
    radioWeek = await getRadioWeek(radioWeek.id)
    radioWeeks.value.isProccessing = false
    if(!radioWeek) return;

    radioWeeks.value.list = radioWeeks.value.list.map((techRec) => techRec.id == radioWeek.id ? radioWeek : techRec)

    radioWeekForm.value.show = true
    radioWeekForm.value.data = {name: radioWeek.name, start_date: radioWeek.startDate, end_date: radioWeek.endDate}

    radioWeekForm.value.update = radioWeek
}

const closeModal = () => {
    radioWeekForm.value.show = false
    radioWeekForm.value.errors = []
}

watchEffect(() => {
    if(!radioWeekForm.value.show) {
        radioWeekForm.value.response = null
        radioWeekForm.value.errors = []
        if(radioWeekForm.value.update) {
            radioWeekForm.value.data = radioWeekForm.value.defaultData;
            radioWeekForm.value.update = null
        }

    }
})

const deleteRadioWeek = (radioWeek) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroyRadioWeek(radioWeek)
}


getRadioWeeks()

const searchTiemout = ref(null);

const onSearch = (event) => {
    if(searchTiemout.value) {
        clearTimeout(searchTiemout.value)
    }

    radioWeeks.value.search = event.target.value;
    searchTiemout.value = setTimeout(() => {
        getRadioWeeks();
    }, 600)
}

semesters.value.data_type = 'select';
getSemesters();
</script>
<template>
    <!-- RadioWeeks list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between mb-4">
                <h6 class="h7" v-text="trans('Radio Weeks')"></h6>
                <div class="text-end">
                    <button class="primary-button" @click="radioWeekForm.show = !radioWeekForm.show">
                        {{ trans('Add radio week') }}
                    </button>
                </div>
            </div>

        </template>

        <!-- Card Body -->
        <div>
            <!-- Waiting for radioWeeks response (Loading) -->
            <template v-if="!radioWeeks.response">
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
            <template v-else-if="radioWeeks.response.status != 200">
                <div class="text-center text-danger"
                    v-text="radioWeeks.response.data.message || radioWeeks.response.statusText"></div>
            </template>

            <!-- If no radioWeeks data -->
            <template v-else-if="radioWeeks.list.length == 0">
                <div class="text-center">{{ trans('No Data') }}</div>
            </template>

            <!-- else Show radioWeeks list -->
            <template v-else>
                <MainTableComponent>
                    <template #thead>
                        <tr>
                            <th>{{ trans('Semester') }}</th>
                            <th>{{ trans('Level') }}</th>
                            <th>{{ trans('Week number') }}</th>
                            <th>{{ trans('Start date') }}</th>
                            <th>{{ trans('End date') }}</th>
                            <th>{{ trans('Operations') }}</th>
                        </tr>
                    </template>
                    <tr v-for="radioWeek in radioWeeks.list" :key="radioWeek.id">
                        <td scope="row" v-text="radioWeek.semester.name"></td>
                        <td v-text="radioWeek.levelText"></td>
                        <td v-text="radioWeek.weekNumber"></td>
                        <td v-text="radioWeek.startDateHijri"></td>
                        <td v-text="radioWeek.endDateHijri"></td>
                        <td class="d-flex">
                            <button type="button" class="primary-button p-0 px-2 me-2" @click="editRadioWeek(radioWeek)"><ion-icon
                                    name="create-outline"></ion-icon></button>
                            <button type="button" @click="deleteRadioWeek(radioWeek)"
                                class="button button-red p-0 px-2"><ion-icon name="trash-outline"></ion-icon></button>
                        </td>
                    </tr>
                </MainTableComponent>

                <MainPaginationComponent :meta="radioWeeks.response.data.meta" @updateList="getRadioWeeks" />
            </template>
            <template v-if="radioWeeks.isProccessing && radioWeeks.response">
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

    <!-- Create radioWeek form -->
    <MainModalComponent v-if="radioWeekForm.show" @closeModal="closeModal()" :class="{'w-1000px': true}">
        <div class="p-5 px-4">
            <form @submit.prevent="createRadioWeek()">

                <h6 class="h9 border-bottom pb-3 mb-4" v-text="trans('Week information')"></h6>
                <div class="row">
                    <InputComponent type="select" :searchable="true"
                        label='<ion-icon name="bookmark"></ion-icon>' placeholder="Semester"
                        :errors="radioWeekForm.errors.teacher_id" v-model="radioWeekForm.data.semester_id"
                        :options="semesters.list" :required="true" />

                    <InputComponent type="select" :searchable="true" label='<ion-icon name="school"></ion-icon>' placeholder="Level"  :errors="radioWeekForm.errors.level" v-model="radioWeekForm.data.level" :options="{'primary' : trans('Primary'), 'middle' : trans('Middle') , 'secondary' : trans('Secondary')}"  :required="true">
                    </InputComponent>

                    <InputComponent :errors="radioWeekForm.errors.week_number" label='<ion-icon name="bookmark"></ion-icon>' placeholder="Week number" v-model='radioWeekForm.data.week_number' :required="true" />

                    <InputComponent type="date" :errors="radioWeekForm.errors.start_date"
                        label='<ion-icon name="calendar"></ion-icon>' placeholder="Week start date"
                        v-model='radioWeekForm.data.start_date' :required="true" />

                    <div class="row mx-0 px-0" v-for="(val, weekDay) in radioWeekForm.data.radios" :key="weekDay">
                        <InputComponent class="col-md-3" label='<ion-icon name="calendar"></ion-icon>' :modelValue="trans(weekDay)" :readonly="true" />
                        <InputComponent class="col-md-9" :errors="radioWeekForm.errors['radios.'+weekDay+'.subject']" label='<ion-icon name="bookmark"></ion-icon>' placeholder="Subject" v-model='val.subject' :required="true" />
                    </div>
                </div>


                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="radioWeekForm.processing">
                        {{ radioWeekForm.processing ? trans('Please wait') : (
                            radioWeekForm.update ? trans('Update') : trans('Save')
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
