<script setup>
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
import MainCardComponent from '../../../../vue-components/backend/MainCardComponent.vue'
// import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue'
// import InputComponent from '../../../../vue-components/backend/FormParts/InputComponent.vue';
import MainPaginationComponent from '../../../../vue-components/backend/MainPaginationComponent.vue';
import useCommon from '../../../../vue-services/common';

const { makeFetchAllRef, fetchAll } = useCommon();
//
const subscriptionPaymentsUrl = `${window._app.url}/subscription/payment_history`;

///
const subscriptionPayments = makeFetchAllRef();
const getSubscriptionPayments = async (url = null) => {
    await fetchAll(url ?? subscriptionPaymentsUrl, subscriptionPayments);
}

getSubscriptionPayments();
</script>
<template>
    <!-- SubscriptionPayments list -->
    <MainCardComponent>
        <template #header>
            <div class="d-flex flex-wrap justify-content-between">
                <h6 class="h7" v-text="trans('Payments history')"></h6>
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
                                <th scope="col">{{ trans('Payment method') }}</th>
                                <th scope="col">{{ trans('Period') }}</th>
                                <th scope="col">{{ trans('Amount') }}</th>
                                <th scope="col">{{ trans('Payment status') }}</th>
                                <th scope="col">{{ trans('Comment') }}</th>
                            </tr>
                        </template>
                        <tr v-for="subscriptionPayment in subscriptionPayments.list" :key="subscriptionPayment.id">
                            <td scope="row" v-text="subscriptionPayment.id"></td>
                            <td v-text="trans(subscriptionPayment.plan.name)"></td>
                            <td v-text="subscriptionPayment.paymentMethodText"></td>
                            <td v-text="subscriptionPayment.subscriptionPeriodText"></td>
                            <td>{{ subscriptionPayment.amount + ' ' + trans(subscriptionPayment.currencyText) }}</td>
                            <td>
                                <span class="badge" :class="'bg-'+subscriptionPayment.status" v-text="trans(subscriptionPayment.statusText)"></span>
                            </td>
                            <td style="white-space: pre-wrap;" v-text="subscriptionPayment.comment ?? '/'"></td>
                        </tr>
                </MainTableComponent>

                <MainPaginationComponent :meta="subscriptionPayments.response.data.meta" @updateList="getSubscriptionPayments" />
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
</template>
