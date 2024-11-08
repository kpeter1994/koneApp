<script setup>
import {Link} from "@inertiajs/vue3";
import {ref, defineProps} from "vue";

const props = defineProps({
    route: String,
    name: String,
    active: Boolean
})
</script>

<template>
    <Link :href="props.route" class="block hover:text-blue-600 flex gap-3 items-center text-sm" >
        <div class="w-10 h-10 flex justify-center items-center  rounded-xl " :class="active ? 'bg-blue-500 text-white' : 'bg-neutral-200 text-blue-500 hover:bg-blue-200' ">
            <slot></slot>
        </div>
        {{ props.name }}
    </Link>

</template>

<style scoped>

</style>
