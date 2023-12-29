<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    class: {
        type: String,
    },
});


</script>

<template>
    <Link :href="href" :class="props.class">
        <slot />
    </Link>
</template>
