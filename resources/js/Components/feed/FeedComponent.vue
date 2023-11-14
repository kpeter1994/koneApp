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

<!--        <div class="border-t p-1.5 text-right">-->
<!--            <a href="" class="font-semibold text-gray-500 hover:text-gray-600 transition-all ">-->
<!--                <i class="fa-solid fa-comment"></i>-->
<!--                Hozzászólás-->
<!--            </a>-->
<!--        </div>-->

<!--        <div class="flex w-full gap-1.5">-->
<!--            <div class="w-10 h-10 bg-gray-900 rounded-full flex justify-center items-center">-->
<!--                <span class="text-white">{{formater.getMonogram(props.feed.creator.name)}}</span>-->
<!--            </div>-->
<!--            <div class="bg-gray-100 p-3 rounded-2xl w-full">-->
<!--                <div class="flex flex-col gap-1.5">-->
<!--                        <span class="font-semibold text-sm">{{props.feed.creator.name}}</span>-->
<!--                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>-->
<!--                        <span class="text-gray-500 text-sm"><i class="fa-solid fa-clock opacity-75 mr-1.5"></i>{{formater.formatDate(props.feed.created_at)}}</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

    </div>
</template>

<style scoped>

</style>
