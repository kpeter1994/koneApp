<script setup>
import {ref, onMounted} from 'vue'
import {useIntersectionObserver} from '@vueuse/core';

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    limit: {
        type: Number,
        default: 13
    }
});

const items = ref([]);
const observerElement = ref(null);
const currentIndex = ref(0); // Hozzáadott index változó


const {stop} = useIntersectionObserver(
    observerElement,
    ([{isIntersecting}], observerElement) => {
        if (isIntersecting) {
            loadMoreItems();
        }
    },
    {threshold: 1}
);

function loadMoreItems() {
    const nextIndex = currentIndex.value + props.limit;
    // Itt töltsd be az új elemeket. Például:
    for (let i = currentIndex.value; i < nextIndex && i < props.data.length; i++) {
        items.value.push(props.data[i]);
    }
    currentIndex.value = nextIndex; // Frissítsd az indexet
}



</script>


<template>


    <template v-for="item in items">
        <slot :item="item"></slot>
    </template>
    <div ref="observerElement">Töltés...</div>

</template>

<style scoped>

</style>
