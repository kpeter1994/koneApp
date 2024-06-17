<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import {onClickOutside,} from "@vueuse/core";
import NavLink from "@/Components/NavLink.vue";
import ToastComponent from "@/Components/notification/ToastComponent.vue";
import {formater} from "@/utils.js";
import NativeLink from "@/Components/NativeLink.vue";
import ExtractComponent from "@/Pages/Posts/component/ExtractComponent.vue";

const props = defineProps({
    user: Object,
    posts: Object,
    flash: Object,
    search: String
})

const createVisible = ref(false)
const target = ref(null)
const form = useForm({})
const close = () => createVisible.value = false

onClickOutside(target, close)

const search = ref(props.search)

watch([search], (newSearch) => {

    form.get(route('posts.index', {search: newSearch}), {
        preserveState: true,
        replace: true
    })
})


</script>

<template>
    <Head title="Hírfolyam"/>

    <AuthenticatedLayout>

        <template #toast>
            <ToastComponent :flash="props.flash"></ToastComponent>
        </template>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i
                class="fa-solid fa-book-open opacity-75 mr-1.5"></i>Tudástár</h2>
        </template>


        <Transition name="slide-up" appear>
            <div class="py-6 px-3">
                <div class="max-w-7xl mx-auto flex justify-end">
                    <NavLink :href=" route('posts.create')" class="hover:border-transparent "
                             :active="route().current('posts.create')">
                        <i class="fa-solid fa-plus mr-1.5"></i>Új bejegyzés
                    </NavLink>

                </div>

                <div class="max-w-4xl mx-auto">

                    <div class="mt-3">
                        <input class="w-full rounded" v-model="search" type="text">
                    </div>


                        <TransitionGroup name="fade" tag="div" class="flex flex-wrap">

                            <div class="w-full px-6 pt-6 pb-12 bg-white rounded-2xl mt-6 flex gap-3 shadow relative" v-for="post in props.posts" :key="post.id">
                                <div class="w-3/4">
                                    <NativeLink class="text-blue-500 text-lg font-semibold mb-6 hover:text-blue-600"
                                                :href="route('posts.show',post.slug)">{{ post.title }}
                                    </NativeLink>

                                    <ExtractComponent :search="search" :body="post.body"></ExtractComponent>

                                </div>

                                <div class="aspect-[1/1] overflow-hidden rounded-2xl w-1/4" >
                                    <img class="w-full h-full object-cover" :src="post.image" alt="">
                                </div>

                                <div class="absolute bottom-6 left-6">
                                    <NativeLink :href="route('posts.edit', post.id)"
                                                class="ml-1.5 text-blue-400 hover:text-blue-500">
                                        <i class="fa-solid fa-pen"></i>
                                    </NativeLink>
                                </div>

                            </div>


                        </TransitionGroup>

                </div>
            </div>
        </Transition>


    </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

.fade-move,
.fade-enter-active,
.fade-leave-active {
    transition: all 0.5s;
}

.fade-leave-active {
    position: absolute;
}

</style>
