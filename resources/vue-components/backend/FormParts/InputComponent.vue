<script setup>
import { ref, useSlots, onMounted, nextTick, inject } from 'vue';
import useCommon from '../../../vue-services/common';

const emit = defineEmits(['onFileUpload', 'onChange', 'update:modelValue'])

const trans = inject('trans');

const slots = useSlots();

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
    },
    minDate: {
        type: String,
        default: null
    },
    maxDate: {
        type: String,
        default: null
    },

})

const showSelectDropdown = ref(false)
const search = ref('')

let CancelToken;
let source;

let isProccessing = false;

const uploadEvents = ref({});

const getRandomIntInRange = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min;

const inputId = 'input_'+ Math.random().toString(36).substr(2, 9);;

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
            emit('onFileUpload', res.data, file);
            emit('update:modelValue', res.data.path)
        }else{
            document.getElementById(inputId).value = '';
        }
    }else {
        document.getElementById(inputId).value = '';
    }
}

const datepickerRef = ref(null);

onMounted(async () => {
    if (props.type == 'date') {
        await nextTick();
        const hijriDatepicker = $(datepickerRef.value);

        let dateOptions = {
            hijri: true,
            locale:$('html').attr('lang') == 'ar' ? 'ar-SA' : 'en-US',
            defaultDate: props.modelValue,
            format:'YYYY-MM-DD',
            hijriFormat:'iYYYY-iMM-iDD',
            timeZone:'Asia/Riyadh',
            isRTL: $('body').hasClass('rtl'),
            ignoreReadonly: true,
            showClear: true,
            showTodayButton: true,
            // showSwitcher:false
        };

        if (props.minDate) {
            dateOptions.minDate = props.minDate;
        }

        if (props.maxDate) {
            dateOptions.maxDate = props.maxDate;
        }

        hijriDatepicker.hijriDatePicker(dateOptions);

        // Attach the dp.change event listener
        hijriDatepicker.on("dp.change", (e) => {
            let miladiDate = '';

            if(e.date) {
                miladiDate = e.date.format("YYYY-MM-DD");
            }

            emit('update:modelValue', miladiDate)
        });

        // hijriDatepicker.on("dp.update", (e) => {
        //     console.log('gg')
        // });
    }
})
</script>
<template>
    <div class="form-input mb-3">
        <div v-if="slots.customLabel">
            <label :for="inputId" class="d-block">
                <slot name="customLabel"></slot>
            </label>
        </div>
        <label :for="inputId" class="label_" @click="showSelectDropdown = !showSelectDropdown" v-if="label && !slots.customLabel"><span v-html="trans(label)"></span> <span v-if="required" class="text-danger">*</span></label>

        <input v-if="(['text', 'email', 'password']).includes(type)" :type="type" class="input_"
            :class="{ 'is-invalid': errors }" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)" :placeholder="trans(placeholder || label) + (!required ? ' ('+trans('Optional')+')' : '')" :id="inputId" :readonly="readonly" :required="required">

        <input v-else-if="type == 'date'" type="text" class="input_ datepicker_input" readonly
            :class="{ 'is-invalid': errors }"
            :placeholder="trans(placeholder || label)" :id="inputId" :readonly="readonly" :required="required" ref="datepickerRef">

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
                    {{ options[modelValue] || (trans(placeholder || label)+'...')}}
                </div>
                <div class="custom-select-dropdown" v-if="showSelectDropdown">
                    <div class="custom-select-search">
                        <input type="text" :placeholder="trans('Search')" v-model="search">
                    </div>
                    <div class="custom-select-options">
                        <div :class="{'custom-select-option': true, 'selected': modelValue==optionKey, 'hide': search && !option.toLowerCase().includes(search.toLowerCase())}" v-for="option, optionKey in options" @click="isModel ? $emit('update:modelValue', optionKey) : $emit('onChange', optionKey); showSelectDropdown=false" v-text="option">
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <textarea v-if="type == 'textarea'" :type="type" class="form-control" :rows="rows" :cols="cols"
            :class="{ 'is-invalid': errors }"
            @input="$emit('update:modelValue', $event.target.value)" :placeholder="trans(placeholder || label)" :required="required" v-text="modelValue"></textarea>

        <template v-else-if="type == 'file'">
            <input type="file" :class="{'form-control': true, 'is-invalid': errors, 'd-none' : slots.customLabel}" :multiple="multiple"
                @change="uploadFile($event.target, path)" :placeholder="trans(placeholder || label)" :required="required" :id="inputId">
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
