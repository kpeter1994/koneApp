<script setup>
import { defineProps, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {onClickOutside} from '@vueuse/core'

const props = defineProps({
    orders: Object,
});

const formVisited = ref(false)
const selectedWorker = ref(null);

const handleClicked = (worker) => {
    selectedWorker.value = worker;
}

const target = ref(null)

const close = () => formVisited.value = false


onClickOutside(target, close)


</script>

<template>
    <Head title="Karbantartók elérhetősége" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Karbantartók</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-gray-900 font-semibold mb-3">Karbantartók elérhetősége</h2>

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Név
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Státusz
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Státusz kezdete
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Státusz vége
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in props.orders" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ order.worker.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ order.status }}
                            </td>
                            <td class="px-6 py-4">
                                {{ order.start_status }}
                            </td>
                            <td class="px-6 py-4">
                                {{ order.end_status }}
                            </td>
                            <td class="px-6 py-4 text-right">
<!--                                <button-->
<!--                                    @click="handleClicked(worker)"-->
<!--                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center">-->
<!--                                    <i class="fa-regular fa-calendar-days mr-1.5 opacity-75"></i>-->
<!--                                    Beosztás-->
<!--                                </button>-->
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </AuthenticatedLayout>
</template>
