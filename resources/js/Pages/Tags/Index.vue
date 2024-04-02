<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";
import {onClickOutside, } from "@vueuse/core";
import NavLink from "@/Components/NavLink.vue";
import ToastComponent from "@/Components/notification/ToastComponent.vue";
import {formater} from "@/utils.js";
import NativeLink from "@/Components/NativeLink.vue";



const props = defineProps({
    user: Object,
    posts: Object,
    flash: Object
})



const createVisible = ref(false)
const target = ref(null)

const close = () => createVisible.value = false

onClickOutside(target, close)
</script>

<template>
    <Head title="Hírfolyam" />

    <AuthenticatedLayout>

        <template #toast>
            <ToastComponent :flash="props.flash"></ToastComponent>
        </template>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-book-open opacity-75 mr-1.5"></i>Tudástár</h2>
        </template>

        <Transition name="slide-up" appear>
            <div class="py-6 px-3">
            <div class="max-w-7xl mx-auto flex justify-end">
                <NavLink :href=" route('posts.create')" class="hover:border-transparent " :active="route().current('posts.create')">
                    <i class="fa-solid fa-plus mr-1.5"></i>Új bejegyzés
                </NavLink>

            </div>

            <div class="max-w-7xl mx-auto">

                <div class="flex flex-wrap">

                    <div class="lg:w-1/4 p-3" v-for="post in props.posts" :key="post.id">
                        <div class="bg-slate-100 rounded-2xl shadow hover:shadow-xl transition-all border border-slate-200">
                            <NativeLink :href="route('posts.show',post.slug)">
                                <div class="aspect-[5/4] overflow-hidden rounded-2xl">
                                    <img :src="post.image" alt="" class="w-full h-full object-cover">
                                </div>
                            </NativeLink>

                            <div class="p-6">
                                <NativeLink class="text-blue-500 font-semibold hover:text-blue-600" :href="route('posts.show',post.slug)">{{post.title}}</NativeLink>

                                <div class="flex justify-between mt-3 text-sm">
                                    <span class="text-gray-500">{{formater.formatDate(post.created_at)}}</span>
                                    <div>
                                        <span class="text-gray-500">{{post.user.name}}</span>
                                        <NativeLink :href="route('posts.edit', post.id)" class="ml-1.5 text-blue-400 hover:text-blue-500">
                                            <i class="fa-solid fa-pen"></i>
                                        </NativeLink>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>
        </Transition>


    </AuthenticatedLayout>
</template>
