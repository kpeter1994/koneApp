<script setup>
import {formater} from "@/utils.js";
import CreateCommentComponent from "@/Components/feed/CreateCommentComponent.vue";
import TaskSolvedButton from "@/Components/partials/TaskSolvedButton.vue";
import {ref, watch} from "vue";

const props = defineProps({
    feed: Object
})

const feed = ref(props.feed)

const handleFeedUpdated = (updatedFeed) => {
    feed.value = updatedFeed ;
}



</script>

<template>
    <div class="p-3 bg-white border-2 rounded-2xl mt-3 flex flex-col gap-1.5 shadow"
         :class="feed.type === 'task' ? 'border-blue-500' : 'border-transparent' "
    >
        <div class="flex gap-1.5 relative">
            <div>
                <div class="w-10 h-10 bg-gray-900 rounded-full flex justify-center items-center">
                    <span class="text-white">{{formater.getMonogram(feed.creator.name)}}</span>
                </div>
            </div>
            <div class="flex flex-col gap-1.5">
                <span class="font-semibold text-sm">{{feed.creator.name}}</span>
                <span class="text-gray-500 text-sm"><i class="fa-solid fa-clock opacity-75 mr-1.5"></i>{{formater.formatDate(props.feed.created_at)}}</span>
            </div>

            <TaskSolvedButton @feedUpdated="handleFeedUpdated" v-if="feed.type === 'task'" :feed="feed"></TaskSolvedButton>
        </div>

        <p v-html="feed.message"></p>

       <div class="border-t p-1.5 text-right">
           <a href="" class="font-semibold text-gray-500 hover:text-gray-600 transition-all ">
               <i class="fa-solid fa-comment"></i>
               Hozzászólás
           </a>
       </div>

       <div v-if="feed.comments.length > 0"
            v-for="comment in props.feed.comments"
            class="flex w-full gap-1.5">
           <div class="w-10 h-10 bg-gray-900 rounded-full flex justify-center items-center">
               <span class="text-white">{{formater.getMonogram(comment.creator.name)}}</span>
           </div>
           <div class="bg-slate-100 p-3 rounded-2xl w-full">
               <div class="flex flex-col gap-1.5">
                       <span class="font-semibold text-sm">{{comment.creator.name}}</span>
                       <p v-html="comment.message"></p>
                       <span class="text-gray-500 text-sm"><i class="fa-solid fa-clock opacity-75 mr-1.5"></i>{{formater.formatDate(comment.created_at)}}</span>
               </div>
           </div>
       </div>

        <CreateCommentComponent :feed="feed"></CreateCommentComponent>

    </div>
</template>

<style scoped>

</style>
