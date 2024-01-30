import './bootstrap';
import translation from '../../vue-services/translation';

import { createApp, provide } from 'vue';

const app = createApp({});

import SubscriptionsComponent from './admin/components/SubscriptionsComponent.vue';
import SubscriptionPaymentsComponent from './admin/components/SubscriptionPaymentsComponent.vue';
import SubscriptionsStatsByPlanComponent from './admin/components/SubscriptionsStatsByPlanComponent.vue';
import ChartJsComponent from './components/ChartJsComponent.vue';
import NavbarNotificationsComponent from '../../vue-components/backend/NavbarNotificationsComponent.vue';
import NotificationsComponent from '../../vue-components/backend/NotificationsComponent.vue';
import SemestersComponent from './admin/components/SemestersComponent.vue';

app.component('subscriptions-component', SubscriptionsComponent);
app.component('subscription-payments-component', SubscriptionPaymentsComponent);
app.component('subscriptions-stats-by-plan-component', SubscriptionsStatsByPlanComponent);
app.component('chartjs-component', ChartJsComponent);
app.component('navbar-notifications-component', NavbarNotificationsComponent);
app.component('notifications-component', NotificationsComponent);
app.component('semesters-component', SemestersComponent);

app.provide('trans', translation.translate);

app.config.globalProperties.trans = translation.translate;
app.config.compilerOptions.isCustomElement = (tag) => tag.startsWith('ion-icon');
app.mount('#app');
