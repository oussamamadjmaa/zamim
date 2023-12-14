import './bootstrap';
import translation from '../../vue-services/translation';

import { createApp } from 'vue';

const app = createApp({});

import OurSubscribersSliderComponent from './components/OurSubscribersSliderComponent.vue';
import FaqItemComponent from './components/FaqItemComponent.vue';
import RegisterFormComponent from './components/RegisterFormComponent.vue';

app.component('our-subscribers-slider-component', OurSubscribersSliderComponent);
app.component('faq-item-component', FaqItemComponent);
app.component('register-form-component', RegisterFormComponent);

app.config.globalProperties.preferredMode = localStorage.getItem('preferredMode');
app.config.globalProperties.trans = translation.translate;
app.config.compilerOptions.isCustomElement = (tag) => tag.startsWith('ion-icon');
app.mount('#app');
