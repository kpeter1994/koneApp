<script setup>
import {formater} from "@/utils.js";

const props = defineProps({
    feed: Object
})
</script>

<template>
    <div class="p-3 bg-white rounded-2xl mt-3 flex flex-col gap-1.5">
        <div class="flex gap-1.5">
            <div>
                <div class="w-10 h-10 bg-gray-900 rounded-full flex justify-center items-center">
                    <span class="text-white">{{formater.getMonogram(props.feed.creator.name)}}</span>
                </div>
            </div>
            <div class="flex flex-col gap-1.5">
                <span class="font-semibold text-sm">{{props.feed.creator.name}}</span>
                <span class="text-gray-500 text-sm"><i class="fa-solid fa-clock opacity-75 mr-1.5"></i>{{formater.formatDate(props.feed.created_at)}}</span>
            </div>
        </div>

        <p v-html="props.feed.message"></p>
    </div>
</template>

<style scoped>

</style>
