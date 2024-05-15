<template>
    <div class="bg-white border rounded-16 py-4 px-4 h-100">
        <div>
            <h6 class="h7" v-text="trans('Subscription plan')"></h6>
        </div>

        <!-- Waiting for stats response (Loading) -->
        <template v-if="!stats.response">
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
            <template v-else-if="stats.response.status != 200">
                <div class="text-center text-danger"
                    v-text="stats.response.data.message || stats.response.statusText"></div>
            </template>

            <!-- else Show stats -->
            <template v-else>
                <div class="active-radios-chart">
                    <div class="active-radios-chart__container">
                        <canvas id="SubscriptionsStatsByPlan" height="140"></canvas>
                    </div>
                </div>
            </template>

            <template v-if="stats.isProccessing && stats.response">
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
</template>
<script setup>
import { onMounted } from 'vue';
import useCommon from '../../../../vue-services/common';


const { makeFetchAllRef, fetchAll } = useCommon();
//
const pageUrl = `${window._app.url}/subscriptions/stats/plans-subsribers`;

///
const stats = makeFetchAllRef();

const getStats = async (url = null) => {
    await fetchAll(url || pageUrl, stats);
}


const makeChart = () => {
    const ctx = document.getElementById('SubscriptionsStatsByPlan');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: stats.value.list.labels,
            datasets: [{
                label: 'عدد المشتركين',
                data: stats.value.list.data,
                borderColor: 'transparent',
                backgroundColor: ['#0864AF', '#D95D13'],
                borderRadius: 12,
                barPercentage: 0.2,
                offset: true,
                rtl: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'start',
                    display: false,
                },
            },
            scales: {
                y: {
                    position: 'right',
                    ticks: {
                        min: 1,
                        callback: function(value, index, values) {
                            // Customize the tick values as needed
                            return value % 1 === 0 ? value : '';
                        },
                        font: {
                            family: "Tajawal",
                        }
                    },
                    border: {
                        width: 0,
                    },
                    clip: false,
                },
                x: {
                    reverse: true,
                    offset: true,
                    border: {
                        width: 0,
                    },
                    grid: {
                        display: false, // Hide x-axis grid lines
                    },
                    ticks: {

                        font: {
                            family: "Tajawal",
                        }
                    }

                },
            },
            layout: {
                direction: 'rtl', // Set the direction to RTL
            },
        }
    });
}

onMounted( async () => {
    await getStats();
    makeChart();
})
</script>
