<script setup>
import { watch, inject, ref } from 'vue';
import useArticles from '../services/articles-service.js'
import useSemesters from '../services/semesters-service.js'
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';
import { cloneDeep } from 'lodash';

//Injections
const trans = inject('trans');

//Services
const { articles, getArticles, getArticle, storeArticle, articleForm, destroyArticle, radios, getRadios } = useArticles()
const { semesters, getSemesters } = useSemesters();

//Component vars
const uploadedAttachment = ref(null);

//API Actions
const createArticle = async () => {
    await storeArticle();

    if (articleForm.value.response.status == 200 && !articleForm.value.update) {
        articleForm.value.show = false;
    }
}
const editArticle = async (article) => {
    articles.value.isProccessing = true
    article = await getArticle(article.id)
    articles.value.isProccessing = false
    if (!article) return;

    articles.value.list = articles.value.list.map((techRec) => techRec.id == article.id ? article : techRec)

    articleForm.value.show = true
    articleForm.value.data = { title: article.title, radio_id: article.radio.id, attachment: article.attachment.path }

    radios.value.extraParams.semester_id = article.radio.semester_id;
    radios.value.extraParams.level = article.radio.level;
    radios.value.extraParams.week_number = article.radio.week_number;

    articleForm.value.update = article
    uploadedAttachment.value = null;
}

const deleteArticle = (article) => {
    if (!confirm(trans('Do you really want to delete this record?'))) return;

    destroyArticle(article)
}

//Component Actions
const closeModal = () => {
    articleForm.value.show = false
    articleForm.value.errors = []
}

//Watches
watch(() => articleForm.value.show, (newVal) => {
    if (!newVal) {
        articleForm.value.response = null
        articleForm.value.errors = []
        if (articleForm.value.update) {
            articleForm.value.data = articleForm.value.defaultData;
            articleForm.value.update = null
            uploadedAttachment.value = null
        }
    }
})

const getRadiosTimeout = ref(null);
watch(radios.value.extraParams, (extraParams) => {
    if (getRadiosTimeout.value) {
        clearTimeout(getRadiosTimeout.value)
    }
    getRadiosTimeout.value = setTimeout(async () => {
        if (extraParams.semester_id && extraParams.level) {
            await getRadios();

            radios.value.show = true;
        } else {
            radios.value.show = false;
        }
    }, 600);
}, { deep: true })

let oldArticlesExtraParams = {};

watch(articles.value.extraParams, (extraParams) => {

    if (extraParams.semester_id != oldArticlesExtraParams.semester_id || extraParams.level != oldArticlesExtraParams.level) {
        articles.value.extraParams.radio_id = null;
        articles.value.extraParams.week_number = null;
    }

    if (extraParams.radio_id != articleForm.value.data.radio_id) {
        articleForm.value.data.radio_id = extraParams.radio_id;
    }

    radios.value.extraParams.semester_id = extraParams.semester_id;
    radios.value.extraParams.level = extraParams.level;
    radios.value.extraParams.week_number = extraParams.week_number;

    getArticles()

    oldArticlesExtraParams = cloneDeep(extraParams);
}, { deep: true })

//Initiale Fetches
const urlParams = window.urlParams;
articles.value.extraParams.semester_id = urlParams.get('semester_id');
articles.value.extraParams.level = urlParams.get('level');
articles.value.extraParams.week_number = urlParams.get('week_number');

getArticles()

semesters.value.dataType = 'select';
getSemesters();

radios.value.show = false;
</script>
<template>
    <!-- Articles list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between mb-4">
                <h6 class="h7" v-text="trans('Articles')"></h6>
                <div class="text-end">
                    <button class="primary-button" @click="articleForm.show = !articleForm.show">
                        {{ trans('Add new article') }}
                    </button>
                </div>
            </div>

            <div class="mb-4 d-flex flex-wrap">
                <InputComponent type="select" :searchable="true" label='<ion-icon name="bookmark"></ion-icon>'
                    placeholder="Semester" v-model="articles.extraParams.semester_id" :options="semesters.list" />

                <InputComponent v-if="articles.extraParams.semester_id" type="select" :searchable="true"
                    label='<ion-icon name="school"></ion-icon>' placeholder="Level" v-model="articles.extraParams.level"
                    :options="{ 'primary': trans('Primary'), 'middle': trans('Middle'), 'secondary': trans('Secondary') }"
                    :required="true">
                </InputComponent>

                <template v-if="articles.extraParams.semester_id && articles.extraParams.level && radios.response && radios.show">
                    <InputComponent label='<ion-icon name="bookmark"></ion-icon>' placeholder="Week number"
                        v-model='articles.extraParams.week_number' />

                    <InputComponent type="select" :searchable="true" label='<ion-icon name="bookmark"></ion-icon>'
                        placeholder="Subject" v-model="articles.extraParams.radio_id" :options="radios.list"
                        :required="true" />
                </template>
            </div>

        </template>

        <!-- Card Body -->
        <div>
            <!-- Waiting for articles response (Loading) -->
            <template v-if="!articles.response">
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
            <template v-else-if="articles.response.status != 200">
                <div class="text-center text-danger"
                    v-text="articles.response.data.message || articles.response.statusText"></div>
            </template>

            <!-- If no articles data -->
            <template v-else-if="articles.list.length == 0">
                <div class="text-center">{{ trans('No Data') }}</div>
            </template>

            <!-- else Show articles list -->
            <template v-else>
                <MainTableComponent>
                    <template #thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Subject') }}</th>
                            <th>{{ trans('Article title') }}</th>
                            <th>{{ trans('Author') }}</th>
                            <th>{{ trans('Public') }}</th>
                            <th>{{ trans('Created at') }}</th>
                            <th>{{ trans('Operations') }}</th>
                        </tr>
                    </template>
                    <tr v-for="article in articles.list" :key="article.id">
                        <td scope="row" v-text="article.id"></td>
                        <td v-text="article.radio.subject"></td>
                        <td v-text="article.title"></td>
                        <td v-text="article.author.name"></td>
                        <td v-text="article.isPublicText"></td>
                        <td v-text="article.createdAt"></td>
                        <td class="d-flex">
                            <a target="_blank" class="primary-button bg-info text-white p-0 px-2 me-2"
                                :href="article.attachment.pathUrl" :title="trans('Download')"><ion-icon
                                    name="download-outline"></ion-icon></a>
                            <button type="button" class="primary-button p-0 px-2 me-2"
                                @click="editArticle(article)"><ion-icon name="create-outline"></ion-icon></button>
                            <button type="button" @click="deleteArticle(article)"
                                class="button button-red p-0 px-2"><ion-icon name="trash-outline"></ion-icon></button>
                        </td>
                    </tr>
                </MainTableComponent>

                <MainPaginationComponent :meta="articles.response.data.meta" @updateList="getArticles" />
            </template>
            <template v-if="articles.isProccessing && articles.response">
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

    <!-- Create article form -->
    <MainModalComponent v-if="articleForm.show" @closeModal="closeModal()" :class="{ 'w-1000px': true }">
        <div class="p-5 px-4">
            <form @submit.prevent="createArticle()">

                <h6 class="h9 border-bottom pb-3 mb-4" v-text="trans('Article information')"></h6>
                <div class="row">
                    <div class="col-12 border mx-0 p-4 mb-4">
                        <h5 class="mb-3" v-text="trans('Choose subject')"></h5>
                        <div class="row">
                            <InputComponent type="select" :searchable="true"
                                label='<ion-icon name="bookmark"></ion-icon>' placeholder="Semester"
                                v-model="radios.extraParams.semester_id" :options="semesters.list" :required="true" />

                            <InputComponent v-if="radios.extraParams.semester_id" type="select" :searchable="true"
                                label='<ion-icon name="school"></ion-icon>' placeholder="Level"
                                v-model="radios.extraParams.level"
                                :options="{ 'primary': trans('Primary'), 'middle': trans('Middle'), 'secondary': trans('Secondary') }"
                                :required="true">
                            </InputComponent>

                            <template v-if="radios.response && radios.show">
                                <InputComponent label='<ion-icon name="bookmark"></ion-icon>' placeholder="Week number"
                                    v-model='radios.extraParams.week_number' />

                                <InputComponent type="select" :searchable="true"
                                    label='<ion-icon name="bookmark"></ion-icon>' placeholder="Subject"
                                    :errors="articleForm.errors.radio_id" v-model="articleForm.data.radio_id"
                                    :options="radios.list" :required="true" />
                            </template>
                        </div>
                    </div>

                    <InputComponent :errors="articleForm.errors.title" label='<ion-icon name="bookmark"></ion-icon>'
                        placeholder="Article title" v-model='articleForm.data.title' :required="true" />

                    <InputComponent type="file" :errors="articleForm.errors.attachment"
                        label='<ion-icon name="file"></ion-icon>' placeholder="Article attachment"
                        v-model='articleForm.data.attachment' @onFileUpload="(data, file) => {
                    uploadedAttachment = { data, file };
                }" path="article-attachments" :required="!articleForm.data.attachment">
                    <template #customLabel>
                        <div class="custom-file-label">
                            <span v-text="trans((!articleForm.data.attachment) ? 'Select article attachment' : 'Change article attachment')"></span>
                        </div>
                    </template>
                    </InputComponent>


                    <div v-if="uploadedAttachment" class="file-upload-progress">
                        <ion-icon name="attach-outline"></ion-icon>
                        <span>(100%) {{ uploadedAttachment.file.name }}</span>
                        <div class="progress" :style="{ 'width': '100%' }"></div>
                    </div>
                </div>


                <div class="mt-3">
                    <button type="submit" class="primary-button" :disabled="articleForm.processing">
                        {{ articleForm.processing ? trans('Please wait') : (
                    articleForm.update ? trans('Update') : trans('Save')
                ) }}
                    </button>
                    <button type="button" class="secondary-button ms-2" @click="closeModal()">{{
                    trans('Close')
                }}</button>
                </div>

                <div class="is-proccessing" v-if="radios.isProccessing">
                    <div class="lds-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </form>
        </div>
    </MainModalComponent>
</template>
