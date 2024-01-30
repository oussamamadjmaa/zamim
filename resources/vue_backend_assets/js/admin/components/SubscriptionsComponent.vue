<script setup>
import { onMounted, ref } from 'vue';
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
// import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
// import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';
import useCommon from '../../../../vue-services/common';

const props = defineProps({
    without_pagination : {
        default: false,
        type: Boolean
    }
})

const { makeFetchAllRef, fetchAll } = useCommon();
//
const pageUrl = `${window._app.url}/subscriptions/all`;
const subscriptionPaymentsHistoryUrl = `${window._app.url}/subscriptions/payments_history`;

///
const subscriptions = makeFetchAllRef();
subscriptions.value.without_pagination = props.without_pagination;

const getSubscriptions = async (url = null) => {
    await fetchAll(url ?? pageUrl, subscriptions);
}

onMounted(() => {
    getSubscriptions();
})

const searchTiemout = ref(null);

const onSearch = (event) => {
    if(searchTiemout.value) {
        clearTimeout(searchTiemout.value)
    }

    subscriptions.value.search = event.target.value;
    searchTiemout.value = setTimeout(() => {
        getSubscriptions();
    }, 600)
}
</script>
<template>
    <!-- Subscriptions list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between">
                <h6 class="h7" v-text="trans('Subscriptions')"></h6>
                <input type="text"
                        class="form-control mb-2" style="max-width: 300px;" :placeholder="trans('Search')" @keyup="onSearch($event)">
                <div class="text-end" v-if="props.without_pagination">
                    <a :href="pageUrl" class="primary-button">
                        {{ trans('Show more') }}
                    </a>
                </div>
            </div>
            <p class="p5 mb-4">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل .</p>
        </template>

        <!-- Card Body -->
        <div>
            <!-- Waiting for subscriptions response (Loading) -->
            <template v-if="!subscriptions.response">
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
            <template v-else-if="subscriptions.response.status != 200">
                <div class="text-center text-danger"
                    v-text="subscriptions.response.data.message || subscriptions.response.statusText"></div>
            </template>

            <!-- If no subscriptions data -->
            <template v-else-if="subscriptions.list.length == 0">
                <div class="text-center">{{ trans('No Data') }}</div>
            </template>

            <!-- else Show subscriptions list -->
            <template v-else>
                <MainTableComponent>
                    <template #thead>
                            <tr>
                                <th>#</th>
                                <th scope="col">{{ trans('School id') }}</th>
                                <th scope="col">{{ trans('School name') }}</th>
                                <th scope="col">{{ trans('Subscription plan') }}</th>
                                <th scope="col">{{ trans('Subscription status') }}</th>
                                <th scope="col">{{ trans('Subscription date') }}</th>
                                <th scope="col">{{ trans('Subscription ends at') }}</th>
                                <th scope="col">{{ trans('Subscription details') }}</th>
                            </tr>
                        </template>
                        <tr v-for="subscription in subscriptions.list">
                            <td scope="row" v-text="subscription.id"></td>
                            <td v-text="subscription.subscriber.id"></td>
                            <td v-text="subscription.subscriber.name"></td>
                            <td v-text="subscription.plan.name"></td>
                            <td><span :class="['badge', `bg-${subscription.status}`]" v-text="subscription.statusText"></span></td>
                            <td class="text-primary" v-text="subscription.startedAt"></td>
                            <td class="text-warning" v-text="subscription.endsAt"></td>
                            <td><a target="_blank" :href="subscriptionPaymentsHistoryUrl+'/subscriber/'+subscription.subscriberId" v-text="trans('Show')"></a></td>
                        </tr>
                </MainTableComponent>

                <MainPaginationComponent v-if="subscriptions.response.data.meta" :meta="subscriptions.response.data.meta" @updateList="getSubscriptions" />
            </template>
            <template v-if="subscriptions.isProccessing && subscriptions.response">
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
