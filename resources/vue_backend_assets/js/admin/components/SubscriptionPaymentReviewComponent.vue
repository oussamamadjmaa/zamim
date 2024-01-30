<script setup>
import { ref } from 'vue';
import MainModalComponent from '../../../../vue-components/backend/MainModalComponent.vue';
import MainTableComponent from '../../../../vue-components/backend/MainTableComponent.vue'
// import SchoolShowComponent from './SchoolShowComponent.vue';
import useCommon from '../../../../vue-services/common';

const props = defineProps({
    subscriptionPayment: Array | Object
})

const emit = defineEmits(['updateSubscriptionPayment'])

const { callApi } = useCommon();

const action = ref(null)
const isProccessing = ref(false)
const comment = ref(null)

const closeActionModal = () => {
    if (isProccessing.value) return;
    action.value = comment.value = null
}

const doAction = async () => {
    isProccessing.value = true
    const res = await callApi({url: `/subscriptions/payments_history/${props.subscriptionPayment.id}/${action.value}`, method: 'POST', data: { comment: comment.value, _method: 'PUT' }});
    isProccessing.value = false

    if (res.status == 200) {
        emit('updateSubscriptionPayment', res.data.data)
        closeActionModal()
    }
}

</script>

<template>
    <div class="p-3">
        <h4 v-text="trans('Subscription payment details')"></h4>
        <MainTableComponent :class="{'fd-bold' : true}">
            <tr>
                <td>ID</td>
                <td v-text="subscriptionPayment.id"></td>
            </tr>
            <tr>
                <td v-text="trans('Payment method')"></td>
                <td v-text="subscriptionPayment.paymentMethodText"></td>
            </tr>
            <tr>
                <td v-text="trans('Plan name')"></td>
                <td v-text="subscriptionPayment.plan.name"></td>
            </tr>
            <tr>
                <td v-text="trans('Period')"></td>
                <td v-text="subscriptionPayment.subscriptionPeriodText"></td>
            </tr>
            <tr>
                <td v-text="trans('Amount')"></td>
                <td v-text="subscriptionPayment.amount + ' ' + trans(subscriptionPayment.currency)"></td>
            </tr>
            <tr>
                <td v-text="trans('Date')"></td>
                <td v-text="subscriptionPayment.initiatedAt"></td>
            </tr>
            <tr>
                <td v-text="trans('Payment status')"></td>
                <td>
                    <span class="badge" :class="'bg-'+subscriptionPayment.status" v-text="trans(subscriptionPayment.statusText)"></span>
                </td>
            </tr>
            <tr v-if="subscriptionPayment.status == 'on_hold'">
                <td v-text="trans('Holded at')"></td>
                <td v-text="subscriptionPayment.onHoldAt"></td>
            </tr>
            <tr v-else-if="subscriptionPayment.status == 'failed'">
                <td v-text="trans('Failed at')"></td>
                <td v-text="subscriptionPayment.failedAt"></td>
            </tr>
            <tr v-else-if="subscriptionPayment.status == 'completed'">
                <td v-text="trans('Completed at')"></td>
                <td v-text="subscriptionPayment.completedAt"></td>
            </tr>
            <tr v-else-if="subscriptionPayment.status == 'canceled'">
                <td v-text="trans('Canceled at')"></td>
                <td v-text="subscriptionPayment.canceledAt"></td>
            </tr>
            <tr v-else-if="subscriptionPayment.status == 'refunded'">
                <td v-text="trans('Refunded at')"></td>
                <td v-text="subscriptionPayment.refundedAt"></td>
            </tr>
            <tr v-if="subscriptionPayment.comment">
                <td v-text="trans('Comment')"></td>
                <td v-text="subscriptionPayment.comment"></td>
            </tr>
            <tr v-if="subscriptionPayment.receipt">
                <td v-text="trans('Payment confirmation receipt')"></td>
                <td>
                    <a :href="subscriptionPayment.receipt" target="_blank">
                        <img :src="subscriptionPayment.receipt" :alt="trans('Payment confirmation receipt')"
                            style="max-width: 400px;">
                    </a>
                </td>
            </tr>
        </MainTableComponent>

        <div class="mt-3 mb-4 text-center" v-if="subscriptionPayment.status == 'in_review'">
            <button type="button" class="button bg-success d-inline me-2"
                v-text="trans('Confirm Payment')" @click="action = 'confirm'"></button>
            <button type="button" class="button bg-danger d-inline" v-text="trans('Cancel Payment')"
                @click="action = 'cancel'"></button>
        </div>

        <!-- <SchoolShowComponent :school="subscriptionPayment.payer" /> -->

        <MainModalComponent :class="{'centered w-500px': true}" v-if="action || isProccessing"
            @closeModal="closeActionModal">
            <div class="p-3">
                <div class="mb-3">
                    <label class="form-label" v-text="trans('Comment')"></label>
                    <textarea class="form-control" rows="2" v-model="comment"></textarea>
                </div>
                <button type="button" :disabled="isProccessing" class="button secondary-button d-inline me-2" v-text="trans('Close')"
                    @click="closeActionModal"></button>
                <button @click="doAction()" type="button" :disabled="isProccessing" v-if="action == 'confirm'"
                    class="button bg-success" v-text="trans('Confirm Payment')"></button>
                <button @click="doAction()" type="button" :disabled="isProccessing" v-else
                    class="button bg-danger" v-text="trans('Cancel Payment')"></button>
            </div>
        </MainModalComponent>
    </div>
</template>
