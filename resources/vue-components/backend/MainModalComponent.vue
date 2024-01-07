<template>
    <div class="custom-modal" @click.self="closeModal">
        <div class="modal-container">
            <div class="close-modal" @click="closeModal">x</div>

            <div class="modal-content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onUpdated, ref, inject } from 'vue';

const trans = inject('trans');
const emit = defineEmits(['closeModal'])
const modalUpdated = ref(false)

const closeModal = () => {
    if(!modalUpdated.value || confirm(trans('Are you sure that you want to close this modal?'))) emit('closeModal');
}

onUpdated(() => {
    modalUpdated.value = true
})
</script>
<style scoped lang="scss">
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: auto;
    background-color: rgb(0, 0, 0, .5);
    z-index: 999;

    &.centered {
        display: grid;
        place-items: center;
    }
    .modal-content {
        background-color: var(--surface);
    }
    transition: all .2s ease-in-out;
    animation: opacity .5s;

    @keyframes opacity {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
}


.modal-container {
    position: relative;
    background-color: #fff;
    z-index: 1;
    width: calc(100% - 1rem);
    max-width: 600px;
    padding: 0;
    border-radius: 10px;
    margin: 3rem auto;

    .close-modal {
        position: absolute;
        right: -13px;
        top: -13px;
        width: 27px;
        height: 27px;
        border-radius: 50%;
        background-color: var(--green);
        color: #fff;
        text-align: center;
        line-height: 27px;
        transition: all .2s ease-in-out;
        cursor: pointer;
        border:none;
        user-select: none;
        z-index: 1;
        &:hover {
            opacity: .95;
        }
        &:active {
            opacity: .8;
        }
    }

    transition: all .2s ease-in-out;
    animation: transform .5s;

    @keyframes transform {
        from {
            transform: translateY(-100%);
        }

        to {
            transform: translateY(0);
        }
    }
}

.w-1000px {
    .modal-container {
        max-width: 1000px!important;
    }
}

.w-800px {
    .modal-container {
        max-width: 800px!important;
    }
}
.w-400px {
    .modal-container {
        max-width: 400px!important;
    }
}

.w-500px {
    .modal-container {
        max-width: 500px!important;
    }
}


</style>
