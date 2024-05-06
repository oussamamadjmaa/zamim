<script setup>
import { watch, inject } from 'vue';
import useRadioWeeks from '../services/radio-weeks-service.js';
import useSemesters from '../services/semesters-service.js';
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue';
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue';
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue';
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';

// Injected translation function
const trans = inject('trans');

// Services
const { radioWeeks, getRadioWeeks, getRadioWeek, storeRadioWeek, radioWeekForm, destroyRadioWeek } = useRadioWeeks();
const { semesters, getSemesters } = useSemesters();

// Levels
const levels = {
    '': 'All',
    'primary': 'Primary',
    'middle': 'Middle',
    'secondary': 'Secondary',
};

// Actions
const createRadioWeek = async () => {
    await storeRadioWeek();
    console.log(radioWeekForm.value.defaultData, radioWeekForm.value.response.status)
    if (radioWeekForm.value.response.status === 200) {
        radioWeekForm.value.data = radioWeekForm.value.defaultData;
        radioWeekForm.value.data.semester_id = radioWeeks.value.extraParams.semester_id;
        radioWeekForm.value.data.level = radioWeeks.value.extraParams.level;
        radioWeekForm.value.show = false;
    }
};

const editRadioWeek = async (radioWeek) => {
    radioWeeks.value.isProccessing = true;
    let res = await getRadioWeek(radioWeek.semesterId, radioWeek.level, radioWeek.weekNumberEn);
    radioWeeks.value.isProccessing = false;
    if (!res) return;

    radioWeekForm.value.show = true;
    radioWeekForm.value.data = { ...res };
    radioWeekForm.value.isUpdate = true;
};


const deleteRadioWeek = (radioWeek) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroyRadioWeek(radioWeek);
};

const closeModal = () => {
    radioWeekForm.value.show = false;
    radioWeekForm.value.errors = [];
};


// Watches
watch(() => radioWeekForm.value.show, (newVal) => {
    if (!newVal) {
        radioWeekForm.value.response = null;
        radioWeekForm.value.errors = [];

        if (radioWeekForm.value.update || radioWeekForm.value.isUpdate) {
            radioWeekForm.value.data = radioWeekForm.value.defaultData;
            radioWeekForm.value.data.semester_id = radioWeeks.value.extraParams.semester_id;
            radioWeekForm.value.data.level = radioWeeks.value.extraParams.level;
            radioWeekForm.value.update = null;
        }

        radioWeekForm.value.isUpdate = false;
    } else {
        if (!Object.values(semesters.value.list).length) {
            semesters.value.dataType = 'select';
            getSemesters();
        }
    }
});

watch(radioWeeks.value.extraParams, (newVal) => {
    radioWeekForm.value.data.semester_id = newVal.semester_id;
    radioWeekForm.value.data.level = newVal.level;

    getRadioWeeks();
}, { deep: true });

// Initial fetch
const urlParams = window.urlParams;
radioWeeks.value.extraParams.semester_id = urlParams.get('semester_id');
radioWeeks.value.extraParams.level = urlParams.get('level');

getRadioWeeks();

semesters.value.dataType = 'select';
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

            <div class="mb-4 d-flex flex-wrap" style="gap: 1rem;">
                <div class="dropdown">
                    <button
                        class="btn btn-secondary dropdown-toggle"
                        type="button"
                        id="filterLevel"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        v-text="trans('Level') + ' (' + trans((levels[radioWeeks.extraParams.level]) || 'All') + ')'"
                    >
                    </button>
                    <div class="dropdown-menu" aria-labelledby="filterLevel">
                        <a v-for="(level, levelKey) in levels" class="dropdown-item" href="#" v-on:click="radioWeeks.extraParams.level = levelKey" v-text="trans(level)"></a>
                    </div>
                </div>

                <div class="dropdown">
                    <button
                        class="btn btn-secondary dropdown-toggle"
                        style="text-wrap: wrap;"
                        type="button"
                        id="filterLevel"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        v-text="trans('Semester') + ' (' + trans((semesters.list[radioWeeks.extraParams.semester_id]) || 'All') + ')'"
                    >
                    </button>
                    <div class="dropdown-menu" aria-labelledby="filterLevel">
                        <a class="dropdown-item" href="#" v-on:click="radioWeeks.extraParams.semester_id = ''" v-text="trans('All')"></a>
                        <a v-for="(semesterName, semesterId) in semesters.list" class="dropdown-item" href="#" v-on:click="radioWeeks.extraParams.semester_id = semesterId" v-text="semesterName"></a>
                    </div>
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
                            <th>{{ trans('Week') }}</th>
                            <th>{{ trans('Semester') }}</th>
                            <th>{{ trans('Level') }}</th>
                            <th>{{ trans('Start date') }}</th>
                            <th>{{ trans('End date') }}</th>
                            <th>{{ trans('Operations') }}</th>
                        </tr>
                    </template>
                    <tr v-for="radioWeek in radioWeeks.list" :key="radioWeek.id">
                        <td scope="row" v-text="radioWeek.weekNumber"></td>
                        <td v-text="radioWeek.semester.name"></td>
                        <td v-text="radioWeek.levelText"></td>
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
