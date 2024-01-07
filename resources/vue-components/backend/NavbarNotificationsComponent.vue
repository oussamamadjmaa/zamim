<script setup>
import { ref } from 'vue';

import useNotifications from '../../vue_backend_assets/js/services/notifications-service';

const { getNotifications, notifications, notificationUrl, notificationsUrl } = useNotifications();

const updateNotifications = (btn) => {
    if(btn.classList.contains('show')) {
        getNotifications()
    }
}
setTimeout(() => {
    getNotifications()
}, 100);

setInterval(() => {
    getNotifications()
}, 10000);
</script>
<template>
    <div class="notifications-dropdown">
        <div class="dropdown">
            <button type="button" :title="trans('Notifications')" class="btn btn-transparent position-relative"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="updateNotifications($event.delegateTarget)">
                <ion-icon name="notifications-outline" style="font-size: 21px;"></ion-icon>
                <span v-if="notifications.data.unreadCount>0" class="position-absolute start-0 translate-middle badge rounded-pill bg-danger"
                    :data-count="notifications.data.unreadCount" style="top: 5px;">
                    <span class="count">{{ notifications.data.unreadCount }}</span>
                    <span class="visually-hidden" v-text="trans('Unseen Notifications')"></span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-notifications-dropdown">
                <div class="pushNotifications__">
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
                        <div class="text-center py-3">{{ trans('No Notifications') }}</div>
                    </template>

                    <template v-else>
                        <a v-for="notification in notifications.data.data" :href="notificationUrl(notification)" class="text-reset notification-item">
                            <div class="py-3 border-bottom" :class="{'bg-light': !notification.readAt}" style="border-color: #bababa6b!important;">
                                <div class="flex-1 px-3">
                                    <h6 class="mb-1" v-text="notification.title"></h6>
                                    <div class="font-size-12 text-muted">
                                        <small class="d-block text-dark" v-text="notification.description"></small>
                                        <small v-text="notification.createdAtForHumans"></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
                <div class="p-2 d-grid border-top">
                    <a class="font-size-14 text-center" :href="notificationsUrl"> <i class="mdi mdi-bell"></i> {{trans('Show all')}}</a>
                </div>
            </div>
        </div>
    </div>
</template>
