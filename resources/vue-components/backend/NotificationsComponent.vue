<script setup>
import MainCardComponent from './MainCardComponent.vue';
import MainPaginationComponent from './MainPaginationComponent.vue';

import useNotifications from '../../vue_backend_assets/js/services/notifications-service';

const { getNotifications, notifications,notificationUrl, notificationsUrl } = useNotifications()

setTimeout(() => {
    getNotifications()
}, 100);

</script>
<template>
    <!-- Notiffications list -->
    <MainCardComponent :class="{'mt-5' : true}">
        <template #header>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex mb-3 mb-md-0">
                    <div class="d-flex flex-wrap">
                        <h5 class="mb-0"><i class="bi bi-bell"></i> {{ trans('Notifications') }}</h5>
                    </div>
                </div>
                <div class="actions flex-grow">
                    <a v-if="false" class="button button-primary py-1" v-text="trans('Mark all as read')"></a>
                </div>
            </div>
        </template>

        <!-- Card Body -->
        <div>
            <!-- Waiting for notifications response (Loading) -->
            <template v-if="!notifications.response">
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
            <template v-else-if="notifications.response.status != 200">
                <div class="text-center text-danger"
                    v-text="notifications.response.data.message || notifications.response.statusText"></div>
            </template>

            <!-- If no notifications data -->
            <template v-else-if="notifications.data.data.length == 0">
                <div class="text-center">{{ trans('No Notifications') }}</div>
            </template>

            <!-- else Show notifications list -->
            <template v-else>
                <div class="mb-4">
                    <a v-for="notification in notifications.data.data" :href="notificationUrl(notification)" class="col-12 px-0 d-block text-dark"
                        href="#">
                        <div class="notification-item___ d-flex py-3 px-3 border-bottom" :class="{'bg-light': !notification.readAt}"
                            style="border-color: #bababa6b!important;">
                            <div class="notification-body__ ms-2">
                                <h5 v-text="notification.title"></h5>
                                <small class="mb-0 d-block" v-text="notification.description"></small>
                                <small class="text-secondary mb-0" v-text="notification.createdAtForHumans"></small>
                            </div>
                        </div>
                    </a>
                </div>
                <MainPaginationComponent :meta="notifications.response.data.meta" @updateList="getNotifications" />
            </template>

            <template v-if="notifications.isProccessing && notifications.response">
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
</template>
