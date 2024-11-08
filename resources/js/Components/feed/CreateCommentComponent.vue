<script setup>

import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    feed: Object
})

const form = useForm({
    message: null,
    creator_id: props.feed.creator.id,
    feed_id: props.feed.id
})

const submit = () => {
    form.post(route('comment.store'), {preserveScroll: true})

    form.message = ''
}



</script>

<template>
    <form class="w-full rounded-lg bg-slate-100  mt-3 overflow-hidden" @submit.prevent="submit">
        <textarea
            v-model="form.message"
            class="resize-none focus:border-transparent focus:outline-none focus:ring-0 w-full min-h-48 border-transparent bg-transparent"
            placeholder="Hozzászólás szövege..."></textarea>

        <div class="flex justify-end p-3">
            <button v-if="form.message">
                <i class="fa-solid text-xl fa-paper-plane text-blue-500 hover:text-blue-400"></i>
            </button>
        </div>

    </form>


</template>

<style scoped>

</style>
