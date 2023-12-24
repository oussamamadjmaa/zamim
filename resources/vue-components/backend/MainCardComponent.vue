
<script setup>
import { useSlots } from 'vue';


const slots = useSlots();

</script>
<template>
    <div class="bg-white border rounded-16 py-5 px-4 h-100 position-relative">
        <div v-if="slots.header">
            <slot name="header"></slot>
        </div>
        <div>
            <slot></slot>
        </div>
    </div>
</template>
