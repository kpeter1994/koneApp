<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';


const props = defineProps({
    post: Object,
})


</script>

<template>
    <Head title="Hírfolyam"/>

    <AuthenticatedLayout>

        <template #toast>
            <!--            <ToastComponent :flash="props.flash"></ToastComponent>-->
        </template>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i
                class="fa-solid fa-book-open opacity-75 mr-1.5"></i><a :href="route('posts.index')">Tudástár</a><i class="fa-solid fa-angle-right text-sm mx-3"></i><span class="text-sm text-gray-500">Bejegyzés</span></h2>
        </template>

        <Transition name="slide-up" appear>
            <div class="py-6 px-3">
            <div id="post" class="max-w-4xl mx-auto">
                <h1 class="text-xl mb-6 font-semibold">{{ props.post.title }}</h1>
                <div v-html="props.post.body">

                </div>
            </div>


        </div>
        </Transition>


    </AuthenticatedLayout>
</template>

<style scoped>

::v-deep(#post div p) {
    font-size: 16px;
    margin-bottom: 0.75rem;
    line-height: 2rem;
}

::v-deep(#post div h2) {
    font-size: 16px;
    line-height: 2rem;
    font-weight: bold;
    margin-bottom: 0.75rem;
}

::v-deep(#post div h3) {
    font-size: 14px;
    line-height: 2rem;
    font-weight: bolder;
    margin-bottom: 0.75rem;

    color: #677e98;
}

::v-deep(#post div li) {
    list-style: disc;
    list-style-position: inside;
    font-size: 16px;
    margin-bottom: 0.375rem;
}

::v-deep(#post div img) {
    margin: 1rem 0;
}
</style>
