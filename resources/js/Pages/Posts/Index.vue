<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FeedComponent from "@/Components/feed/FeedComponent.vue";
import CreateFeedComponent from "@/Components/feed/CreateFeedComponent.vue";
import {ref} from "vue";
import {onClickOutside, } from "@vueuse/core";
import NavLink from "@/Components/NavLink.vue";



const props = defineProps({
    user: Object,
    posts: Object
})



const createVisible = ref(false)
const target = ref(null)

const close = () => createVisible.value = false

onClickOutside(target, close)
</script>

<template>
    <Head title="Hírfolyam" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-book-open opacity-75 mr-1.5"></i>Tudástár</h2>
        </template>


        <div class="py-6 px-3">
            <div class="max-w-7xl mx-auto flex justify-end">
                <NavLink :href=" route('posts.create')" class="hover:border-transparent " :active="route().current('posts.create')">
                    <i class="fa-solid fa-plus mr-1.5"></i>Új bejegyzés
                </NavLink>

            </div>

            <div class="max-w-7xl mx-auto">
                <ul>
                    <li v-for="post in props.posts" :key="post.id">
                        {{post.title}}
                    </li>
                </ul>

            </div>

        </div>


    </AuthenticatedLayout>
</template>
