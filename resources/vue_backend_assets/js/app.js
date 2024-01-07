import './bootstrap';
import translation from '../../vue-services/translation';

import { createApp, provide } from 'vue';

const app = createApp({});

import StudentsComponent from './school/components/StudentsComponent.vue';
import TeachersComponent from './school/components/TeachersComponent.vue';
import RadiosComponent from './school/components/RadiosComponent.vue';
import ActivitiesComponent from './school/components/ActivitiesComponent.vue';
import SubscriptionPaymentsComponent from './school/components/SubscriptionPaymentsComponent.vue';
import ChartJsComponent from './components/ChartJsComponent.vue';
import NavbarNotificationsComponent from '../../vue-components/backend/NavbarNotificationsComponent.vue';
import NotificationsComponent from '../../vue-components/backend/NotificationsComponent.vue';

app.component('students-component', StudentsComponent);
app.component('teachers-component', TeachersComponent);
app.component('radios-component', RadiosComponent);
app.component('activities-component', ActivitiesComponent);
app.component('subscription-payments-component', SubscriptionPaymentsComponent);
app.component('chartjs-component', ChartJsComponent);
app.component('navbar-notifications-component', NavbarNotificationsComponent);
app.component('notifications-component', NotificationsComponent);


app.provide('trans', translation.translate);

app.config.globalProperties.trans = translation.translate;
app.config.compilerOptions.isCustomElement = (tag) => tag.startsWith('ion-icon');
app.mount('#app');
