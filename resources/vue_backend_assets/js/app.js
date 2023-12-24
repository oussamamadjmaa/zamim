import './bootstrap';
import translation from '../../vue-services/translation';

import { createApp, provide } from 'vue';

const app = createApp({});

import StudentsComponent from './school/components/StudentsComponent.vue';
import TeachersComponent from './school/components/TeachersComponent.vue';

app.component('students-component', StudentsComponent);
app.component('teachers-component', TeachersComponent);


app.provide('trans', translation.translate);

app.config.globalProperties.trans = translation.translate;
app.config.compilerOptions.isCustomElement = (tag) => tag.startsWith('ion-icon');
app.mount('#app');
