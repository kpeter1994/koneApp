<script setup>

import {useForm} from "@inertiajs/vue3";
import {formater} from "../../utils.js";

const emit = defineEmits(['close'])

const props = defineProps({
    user: Object,
    feed: Object
})

const form = useForm({
    message: ''
})

const formSubmit = () => {
    form.post(route('feed.store'))
    emit('close')
}

</script>

<template>
    <div class="max-w-2xl lg:w-[600px] bg-gray-50 p-6 rounded-2xl">
        <h2 class="font-semibold text-lg text-gray-800 text-center">Bejegyzés létrehozása</h2>
        <div class="flex gap-1.5">
            <div>
                <div class="w-10 h-10 bg-gray-900 rounded-full flex justify-center items-center">
                    <span class="text-white">{{formater.getMonogram(props.user.name)}}</span>
                </div>
            </div>
            <div class="flex flex-col gap-1.5">
                <span class="font-semibold text-sm">{{props.user.name}}</span>
            </div>
        </div>
        <form @submit.prevent="formSubmit">
            <textarea v-model="form.message" class="w-full h-64 rounded-lg bg-gray-100 border-transparent mt-3 p-3" placeholder="Bejegyzés szövege..."></textarea>
            <button class="w-full bg-gray-600 text-white p-1.5 rounded-2xl">Mentés</button>
        </form>

    </div>
</template>

<style scoped>

</style>
