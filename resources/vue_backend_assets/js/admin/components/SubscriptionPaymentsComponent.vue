<script setup>
import { onMounted, ref } from 'vue';
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
// import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
// import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue';
import SubscriptionPaymentReviewComponent from './SubscriptionPaymentReviewComponent.vue';
import useCommon from '../../../../vue-services/common';

const props = defineProps({
    without_pagination : {
        type: Boolean,
        default: false
    },
    school : {
        type: Object,
        default: null
    }
})

const { makeFetchAllRef, fetchAll, fetchOne } = useCommon();
//
const pageUrl = `${window._app.url}/subscriptions/payments_history`;

///
const subscriptionPayments = makeFetchAllRef();
subscriptionPayments.value.without_pagination = props.without_pagination;

const getSubscriptionPayments = async (url = null) => {
    await fetchAll(url ?? (pageUrl + (props.school ? '/subscriber/'+props.school.id : '')), subscriptionPayments);
}

const getSubscriptionPayment = async (subscriptionPaymentId) => {
    return await fetchOne(`${pageUrl}/${subscriptionPaymentId}`);
}

const setReviewSubscriptionPayment = async (subscriptionPaymentId) => {
    const res = await getSubscriptionPayment(subscriptionPaymentId)

    if(res) {
        reviewPayment.value = res
    }
}
//
const reviewPayment = ref(null);
const updateSubscriptionPayment = (subscriptionPayment) => {
    subscriptionPayments.value.list = subscriptionPayments.value.list.map((sp) => sp.id == subscriptionPayment.id ? subscriptionPayment : sp)
    reviewPayment.value = subscriptionPayment;
}

//
onMounted(async () => {
    getSubscriptionPayments();

    if (props.without_pagination == true) {
        setInterval(() => {
            getSubscriptionPayments();
        }, 10100);
    }

    if(window.urlParams.get('payment_id')) {
        setReviewSubscriptionPayment(window.urlParams.get('payment_id'))
    }
})
</script>
<template>
    <!-- SubscriptionPayments list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between">
                <h6 class="h7" v-text="trans('Payments history')"></h6>
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
            <!-- Waiting for subscriptionPayments response (Loading) -->
            <template v-if="!subscriptionPayments.response">
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
            <template v-else-if="subscriptionPayments.response.status != 200">
                <div class="text-center text-danger"
                    v-text="subscriptionPayments.response.data.message || subscriptionPayments.response.statusText"></div>
            </template>

            <!-- If no subscriptionPayments data -->
            <template v-else-if="subscriptionPayments.list.length == 0">
                <div class="text-center">{{ trans('No Data') }}</div>
            </template>

            <!-- else Show subscriptionPayments list -->
            <template v-else>
                <MainTableComponent>
                    <template #thead>
                            <tr>
                                <th>#</th>
                                <th scope="col">{{ trans('Plan name') }}</th>
                                <th v-if="!props.without_pagination" scope="col">{{ trans('School id') }}</th>
                                <th scope="col">{{ trans('School name') }}</th>
                                <th v-if="!props.without_pagination" scope="col">{{ trans('Payment method') }}</th>
                                <th v-if="!props.without_pagination" scope="col">{{ trans('Period') }}</th>
                                <th scope="col">{{ trans('Amount') }}</th>
                                <th scope="col">{{ trans('Payment status') }}</th>
                                <th v-if="!props.without_pagination" scope="col">{{ trans('Last update') }}</th>
                                <th v-if="!props.without_pagination" scope="col">{{ trans('Operations') }}</th>
                            </tr>
                        </template>
                        <tr v-for="subscriptionPayment in subscriptionPayments.list">
                            <td scope="row" v-text="subscriptionPayment.id"></td>
                            <td v-text="trans(subscriptionPayment.plan.name)"></td>
                            <td v-if="!props.without_pagination" v-text="subscriptionPayment.payer.id"></td>
                            <td><a :href="pageUrl+'/subscriber/'+subscriptionPayment.payer.id" v-text="subscriptionPayment.payer.name"></a></td>
                            <td v-if="!props.without_pagination" v-text="trans(subscriptionPayment.paymentMethodText)"></td>
                            <td v-if="!props.without_pagination" v-text="subscriptionPayment.subscriptionPeriodText"></td>
                            <td>{{ subscriptionPayment.amount + ' ' + trans(subscriptionPayment.currencyText) }}</td>
                            <td>
                                <span class="badge" :class="'bg-'+subscriptionPayment.status" v-text="trans(subscriptionPayment.statusText)"></span>
                            </td>
                            <td v-if="!props.without_pagination" v-text="subscriptionPayment.updatedAt"></td>
                            <td>
                                <button type="button" @click="reviewPayment = subscriptionPayment"
                                    class="btn btn-info p-0 px-2 text-white text-nowrap" :title="trans('Review')"><ion-icon name="eye-outline"></ion-icon> {{  !props.without_pagination ? trans("Review") : '' }}</button>
                            </td>
                        </tr>
                </MainTableComponent>

                <MainPaginationComponent v-if="subscriptionPayments.response.data.meta" :meta="subscriptionPayments.response.data.meta" @updateList="getSubscriptionPayments" />
            </template>

            <template v-if="subscriptionPayments.isProccessing && subscriptionPayments.response">
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

        <!-- Show school modal -->
    <MainModalComponent v-if="reviewPayment" @closeModal="reviewPayment = null" :class="{'w-800px' : true}">
        <SubscriptionPaymentReviewComponent :subscriptionPayment="reviewPayment" @updateSubscriptionPayment="updateSubscriptionPayment" />
    </MainModalComponent>

</template>
