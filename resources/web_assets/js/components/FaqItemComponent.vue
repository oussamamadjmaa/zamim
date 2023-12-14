<script setup>
// import arrowUp from './svg/icons/arrowDown.vue';
import { ref } from 'vue';


const anwserOpen = ref(false);
const showAnswer = () => anwserOpen.value = !anwserOpen.value;

</script>
<template>
    <div class="faq-item mb-4">
        <div @click="showAnswer" class="faq-item-header">
            <div class="faq-question"><slot name="question"></slot></div>
            <div class="faq-arrow" :class="{'transform':anwserOpen}">
                <ion-icon name="add-outline"></ion-icon>
            </div>
        </div>
        <div class="faq-answer" v-if="anwserOpen">
            <slot name="answer"></slot>
        </div>
    </div>
</template>

<style lang="scss">
.faq-item {
    background-color: var(--main-white);
    padding: 24px 32px;
    border-radius: 21px;
    user-select: none;
    max-width: 1028px;
    margin: 0 auto;

    .faq-question {
        font-size: 1rem;
        color: var(--main-gray);

        @media (min-width: 575px) {
            font-size: 1rem;
        }
    }

    &-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        
        cursor: pointer;

        .faq-arrow {
            font-size: 1.25rem;
            color: var(--main-gray);
            @media (min-width: 575px) {
                font-size: 1.5rem;
            }
        }
    }

    .faq-answer {
        padding: 0 1rem;
        margin-top: .2rem;
        animation: opacity .4s ease;
    }

    @keyframes opacity {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
}
</style>