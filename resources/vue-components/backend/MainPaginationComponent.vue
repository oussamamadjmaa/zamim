<script setup>
import { onMounted } from 'vue';

const props = defineProps({
    'meta': Array | Object
})

</script>
<template>
    <nav aria-label="..." v-if="meta.last_page != 1">
        <ul class="pagination">
            <template v-for="link in meta.links" :key="link.url">
                <li class="page-item" :class="{'disabled' : !link.url, 'active' : link.active}">
                    <a v-if="link.url && !link.active" class="page-link" href="javascript:;" @click="$emit('updateList', link.url)" v-html="link.label"></a>
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </template>
        </ul>
    </nav>
</template>
