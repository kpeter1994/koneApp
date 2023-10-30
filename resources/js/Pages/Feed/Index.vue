<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FeedComponent from "@/Components/feed/FeedComponent.vue";
import CreateFeedComponent from "@/Components/feed/CreateFeedComponent.vue";
import {ref} from "vue";
import {onClickOutside, } from "@vueuse/core";



const props = defineProps({
    user: Object,
    feeds: Object
})



const createVisible = ref(false)
const target = ref(null)

const close = () => createVisible.value = false

onClickOutside(target, close)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-rss opacity-75 mr-1.5"></i>Hírfolyam</h2>
        </template>


        <div class="py-6 px-3">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="p-3 bg-white rounded-2xl">
                    <input @click="createVisible = true" placeholder="Bejegyzés létrehozása" class="w-full rounded-full bg-gray-200 border-transparent" type="text">
                </div>

                 <FeedComponent v-for="feed in props.feeds"  :feed="feed"></FeedComponent>


            </div>
        </div>

        <div v-if="createVisible" class="fixed top-0 left-0 bg-gray-900 w-full h-screen z-40 flex justify-center items-center bg-opacity-25 backdrop-blur p-3">
            <CreateFeedComponent :user="props.user" @close="close" ref="target"></CreateFeedComponent>
        </div>
    </AuthenticatedLayout>
</template>
