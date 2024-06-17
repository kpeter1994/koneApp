<script setup>
import { computed } from 'vue';

const props = defineProps({
    search: String,
    body: String,
});

function removeAccents(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

// Function to highlight the search term and show surrounding characters
const highlightedBody = computed(() => {
    const search = removeAccents(props.search);
    const body = removeAccents(props.body);

    if (!search || !body) return props.body;

    const index = body.toLowerCase().indexOf(search.toLowerCase());
    if (index === -1) return props.body; // If search term is not found

    const start = Math.max(0, index - 400);
    const end = Math.min(body.length, index + search.length + 400);

    const before = props.body.substring(start, index);
    const match = props.body.substring(index, index + search.length);
    const after = props.body.substring(index + search.length, end);

    return `${before}<mark>${match}</mark>${after}`;
});
</script>

<template>
    <div v-if="props.search && props.search.length > 2">
        <div v-html="highlightedBody"></div>
    </div>
</template>

<style scoped>
mark {
    color: black;
    font-weight: bold;
}
</style>
