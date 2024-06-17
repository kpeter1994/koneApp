<script setup>
import { computed } from 'vue';

const props = defineProps({
    search: String,
    body: String,
});

// Function to highlight the search term and show surrounding characters
const highlightedBody = computed(() => {
    const search = props.search;
    const body = props.body;

    if (!search || !body) return body;

    const index = body.toLowerCase().indexOf(search.toLowerCase());
    if (index === -1) return body; // If search term is not found

    const start = Math.max(0, index - 400);
    const end = Math.min(body.length, index + search.length + 400);

    const before = body.substring(start, index);
    const match = body.substring(index, index + search.length);
    const after = body.substring(index + search.length, end);

    return `${before}<mark>${match}</mark>${after}`;
});
</script>

<template>
    <div v-if="props.search">
        <div v-html="highlightedBody"></div>
    </div>
</template>

<style scoped>
mark {
    color: black;
    font-weight: bold;
}
</style>
