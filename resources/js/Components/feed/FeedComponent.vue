<script setup>
import {formater} from "@/utils.js";
import CreateCommentComponent from "@/Components/feed/CreateCommentComponent.vue";

const props = defineProps({
    feed: Object
})
</script>

<template>
    <div class="p-3 bg-white rounded-2xl mt-3 flex flex-col gap-1.5 shadow">
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

       <div class="border-t p-1.5 text-right">
           <a href="" class="font-semibold text-gray-500 hover:text-gray-600 transition-all ">
               <i class="fa-solid fa-comment"></i>
               Hozzászólás
           </a>
       </div>

       <div v-if="props.feed.comments.length > 0"
            v-for="comment in props.feed.comments"
            class="flex w-full gap-1.5">
           <div class="w-10 h-10 bg-gray-900 rounded-full flex justify-center items-center">
               <span class="text-white">{{formater.getMonogram(props.feed.creator.name)}}</span>
           </div>
           <div class="bg-slate-100 p-3 rounded-2xl w-full">
               <div class="flex flex-col gap-1.5">
                       <span class="font-semibold text-sm">{{props.feed.creator.name}}</span>
                       <p>{{comment.message}}</p>
                       <span class="text-gray-500 text-sm"><i class="fa-solid fa-clock opacity-75 mr-1.5"></i>{{formater.formatDate(comment.created_at)}}</span>
               </div>
           </div>
       </div>

        <CreateCommentComponent :feed="props.feed"></CreateCommentComponent>

    </div>
</template>

<style scoped>

</style>
