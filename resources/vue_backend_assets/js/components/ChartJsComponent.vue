<script setup>
import { onMounted, ref, version } from 'vue';
import useCommon from '../../../vue-services/common';

const props = defineProps({
    title: {
        type: String,
    },
    stats_url: {
        type: String,
        required: true
    },
    period: {
        type: String,
        default: 'last_week'
    },
    type: {
        type: String,
        default: 'bar'
    },
    version: {
        default: 1
    },
    box: {
        type: Boolean,
        default: true
    },
});
const { makeFetchAllRef, fetchAll } = useCommon();
//

const period = ref(props.period);
const statsUrl = props.stats_url;

///
const stats = makeFetchAllRef();
const getStats = async (url = null) => {
    url = url ?? statsUrl.replace('periodValue', period.value);
    url = new URL(url);
    url.searchParams.append('type', props.type);
    url.searchParams.append('version', props.version);

    await fetchAll(url, stats);

    if (stats.value.response.status == 200 && stats.value.response.data && stats.value.response.data.chartData) {
        makeChart();
    }
}

const myBarChart = ref(null);

const makeChart = () => {
    const ctx = document.getElementById(stats.value.response.data.id);
    if (myBarChart.value) {
        // If the chart already exists, destroy it
        myBarChart.value.destroy();
    }

    let options;
    if (props.type == 'line') {
        options = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'start',
                    display: false
                },
            },
            scales: {
                y: {
                    position: 'right',
                    beginAtZero: props.version == 1 ? false : true,
                    border: {
                        color: '#0864AF',
                        width: props.version == 1 ? 3 : 0,
                        z: 1
                    },
                    ticks: {
                        display: props.version == 1 ? false : true,
                        min: 1,
                        callback: function (value, index, values) {
                            // Customize the tick values as needed
                            return value % 1 === 0 ? value : '';
                        },
                        font: {
                            family: "Tajawal",
                        }
                    },
                    clip: false,
                },
                x: {
                    reverse: true,
                    border: {
                        color: '#0864AF',
                        width: props.version == 1 ? 3 : 0,
                        z: 1
                    },
                    ticks: {
                        display: props.version == 1 ? false : true,
                        font: {
                            family: "Tajawal",
                        }
                    },
                    grid: {
                        display: false, // Hide x-axis grid lines
                    },

                },
            },
            layout: {
                direction: 'rtl', // Set the direction to RTL
                padding: {
                    left: 18, // Adjust the right padding here
                }
            },
        };
    } else {
        options = {
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
                        callback: function (value, index, values) {
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
    }

    myBarChart.value = new Chart(ctx, {
        type: props.type,
        data: stats.value.response.data.chartData,
        options: options
    });

}

const updateStats = (per) => {
    period.value = per;
    getStats(statsUrl.replace('periodValue', per))
}

onMounted(async () => {
    await getStats();
})
</script>
<template>
    <div :class="{'bg-white border rounded-16 py-4 px-4 h-100 position-relative' : props.box}">
        <div :class="{'d-flex flex-wrap justify-content-between':props.box}">
            <h6 class="h7" v-text="title || ''" v-if="props.box"></h6>
            <div v-if="stats.response && stats.response.data && stats.response.data.periods">
                <div class="dropdown" v-if="props.box">
                    <p class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false" v-text="stats.response.data.periods[period]">
                    </p>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li v-for="(periodText, period) in stats.response.data.periods"><a class="dropdown-item"
                                href="javascript:;" @click="updateStats(period)" v-text="periodText"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="p5" v-if="props.box">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل .</p>



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
            <div class="text-center text-danger" v-text="stats.response.data.message || stats.response.statusText"></div>
        </template>

        <!-- else Show stats -->
        <template v-else>
            <div class="chartjs-bar">
                <div class="chartjs-bar__container">
                    <canvas :id="stats.response.data.id" height="140"></canvas>
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
