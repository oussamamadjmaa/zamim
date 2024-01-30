<script setup>
import { computed, ref } from 'vue';
import useCommon from '../../vue-services/common';

const emit = defineEmits(['onFileUpload', 'update:modelValue'])

const { callApi } = useCommon();

const props = defineProps({
    type: {
        type: String,
        default: 'text'
    },
    label: String | null,
    placeholder: String | null,
    errors: Array | Object | null,
    modelValue: {
        type: [Number, String],
        default: null,
        required: false
    },
    required: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    rows: {
        default: false
    },
    cols: {
        default: false
    },
    isModel: {
        type: Boolean,
        default: true
    },
    path: {
        type: String,
        default: null
    },
    multiple: {
        type: Boolean,
        default: false
    },
    help: {
        type: String,
        default: null
    },
    searchable: {
        type: Boolean,
        default: false
    },
    options: {
        type: Object,
        default: {}
    }
})

const showSelectDropdown = ref(false)
const search = ref('')

let CancelToken;
let source;

let isProccessing = false;

const uploadEvents = ref({});

const uploadFile = async (input, path, isFile = false) => {
    let file = input;
    if (!isFile) {
        for (let index = 0; index < input.files.length; index++) {
            uploadFile(input.files[index], path, true)
        }
        return;
    }

    if (!file) return;

    if (isProccessing == true && props.multiple == false) {
        await source.cancel('File changed.');
        isProccessing = false;
    }

    isProccessing = true;

    CancelToken = axios.CancelToken;
    source = CancelToken.source();

    const sourceProg = source;

    const randomInt = new Date().getTime() + Math.random() * 999;

    const res = await callApi({
        url: '/upload',
        method: 'POST',
        data: { file, path },
        headers: { 'Content-Type': 'multipart/form-data' },
        config: {
            cancelToken: source.token,
            onUploadProgress: (progressEvent) => {
                const { loaded, total } = progressEvent;
                let percent = Math.floor((loaded * 100) / total);
                if (percent < 100) {
                    uploadEvents.value[randomInt] = {
                        loaded, total, percent, source: sourceProg, fileInfo: file
                    }
                }
            }
        }
    });

    delete uploadEvents.value[randomInt];

    if (typeof res != "undefined") {
        isProccessing = false;
        if (res.status == 200) {
            emit('onFileUpload', res.data);
            emit('update:modelValue', res.data.path)
        }
    }
}

</script>
<template>
    <div class="form-input mb-3">
        <label class="label_" v-if="label"><span v-html="trans(label)"></span> <span v-if="required" class="text-danger">*</span></label>

        <input v-if="(['text', 'email', 'password', 'date']).includes(type)" :type="type" class="input_"
            :class="{ 'is-invalid': errors }" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)" :placeholder="trans(placeholder || label)" :readonly="readonly" :required="required">


        <template v-else-if="type == 'select'">
            <select v-if="!searchable" class="form-select form-control" :class="{ 'is-invalid': errors }"
                :value="modelValue"
                @change="isModel ? $emit('update:modelValue', $event.target.value) : $emit('onChange', $event.target.value)"
                :required="required">
                <option value="" v-text="trans(placeholder || label)+'...'"></option>
                <slot></slot>
            </select>

            <div v-else :class="{'custom-select': true, 'is-invalid': errors }" v-on:clickout="showSelectDropdown = false">
                <div class="custom-select-selected form-control" @click="showSelectDropdown = !showSelectDropdown" >
                    {{ options[modelValue] || trans(placeholder || label)+'...'}}
                </div>
                <div class="custom-select-dropdown" v-if="showSelectDropdown">
                    <div class="custom-select-search">
                        <input type="text" :placeholder="trans('Search')" v-model="search">
                    </div>
                    <div class="custom-select-options">
                        <div :class="{'custom-select-option': true, 'selected': modelValue==optionKey, 'hide': search && !option.includes(search)}" v-for="option, optionKey in options" @click="$emit('update:modelValue', optionKey); showSelectDropdown=false" v-text="option">
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <textarea v-if="type == 'textarea'" :type="type" class="form-control" :rows="rows" :cols="cols"
            :class="{ 'is-invalid': errors }"
            @input="$emit('update:modelValue', $event.target.value)" :placeholder="trans(placeholder || label)" :required="required" v-text="modelValue"></textarea>

        <template v-else-if="type == 'file'">
            <input type="file" class="form-control" :class="{ 'is-invalid': errors }" :multiple="multiple"
                @change="uploadFile($event.target, path)" :placeholder="trans(placeholder || label)" :required="required">
            <div class="file-upload-progress" v-for="uploadEvent in uploadEvents">
                <a @click="uploadEvent.source.cancel('Canceled by user')" href="javascript:;" class="text-danger">X</a>
                <ion-icon name="attach-outline"></ion-icon>
                <span>({{ uploadEvent.percent }}%) {{ uploadEvent.fileInfo.name }}</span>
                <div class="progress" :style="{'width': uploadEvent.percent+'%'}"></div>
            </div>
        </template>

        <template v-if="help">
            <small class="form-text text-muted" v-text="help"></small>
        </template>

        <ul class="invalid-feedback" v-if="errors">
            <li v-text="error" v-for="error in errors"></li>
        </ul>
    </div>
</template>
