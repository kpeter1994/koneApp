<script setup>
import { defineProps, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {onClickOutside} from '@vueuse/core'
import {formater} from "@/utils.js";
import NativeLink from "@/Components/NativeLink.vue";

const props = defineProps({
    orders: Object,
});

const formVisited = ref(false)
const selectedWorker = ref(null);

console.log(props.orders)
const handleClicked = (worker) => {
    selectedWorker.value = worker;
}

const target = ref(null)

const close = () => formVisited.value = false

const addDuty = (duty, array, isResultArray = false, index = 0) => {

    if (isResultArray) {
        let result = [];
        array.forEach((item) => {
            if (item.status === duty) {
                result.push(item.worker.name);
            }
        });
        return result[index];
    }

    const foundItem = array.find(item => item.status === duty);
    if (foundItem) {
        return foundItem.worker.name;
    }
    return ''; // Vagy valami alapértelmezett érték, ha nincs találat
}

onClickOutside(target, close)


</script>

<template>
    <Head title="Karbantartók elérhetősége" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <NativeLink class="text-blue-500 hover:text-blue-600 underline" :href="route('workers.index')"><i
                    class="fa-solid fa-user-gear opacity-75 mr-1.5"></i>Karbantartók
                </NativeLink>
                <i class="fa-solid fa-angle-right text-sm mx-3"></i><span class="text-sm text-gray-500">Hírfolyam</span>
            </h2>

        </template>

        <Transition name="slide-up" appear>
            <div class="py-6">
            <div class="sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-2xl p-6 mb-6">
                    <table class="rounded-2xl overflow-hidden bg-slate-50 shadow">
                        <tr>
                            <th class="bg-blue-700 text-white uppercase" colspan="8">{{formater.getActualMountName()}}</th>
                        </tr>
                        <tr>
                            <th rowspan="2" class="p-3 text-center"></th>
                            <th rowspan="2" class="p-3 text-center"></th>
                            <th class="p-3 text-center bg-blue-100" colspan="2">Nappal ügyelet</th>
                            <th class="p-3 text-center bg-orange-100">Délután ügyelet</th>
                            <th class="p-3 text-center">Mozgólépcső ügyelet </th>
                            <th class="p-3 text-center">Épülettechnika ügyelet</th>
                            <th class="p-3 text-center">Debrecen és környéke ügyelet</th>
                        </tr>
                        <tr>
                            <td class="text-center bg-blue-100">1. nappalos</td>
                            <td class="text-center bg-blue-100">2. nappalos</td>
                            <td class="text-center bg-orange-100">3. délutános</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr v-for="(dateArray, index) in props.orders" :key="index" :class="formater.isToday(index) ? 'bg-blue-100' : '' ">
                            <td class="p-3">{{formater.getDate(index)}}</td>
                            <td class="p-3">{{formater.getDayName(index)}}</td>
                            <td class="p-3 text-center">{{addDuty('Délelötti ügyeletes',dateArray, true, 0)}}</td>
                            <td class="p-3 text-center">{{addDuty('Délelötti ügyeletes',dateArray, true, 1)}}</td>
                            <td class="p-3 text-center">{{addDuty('Délutáni ügyeletes',dateArray)}}</td>
                            <td class="p-3 text-center">{{addDuty('Mozgólépcső ügyeletes',dateArray)}}</td>
                            <td class="p-3 text-center">{{addDuty('Épülettechnika ügyeletes',dateArray)}}</td>
                            <td class="p-3 text-center">{{addDuty('Debrecen',dateArray)}}</td>
                        </tr>
                    </table>
                </div>
<!--                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">-->
<!--                    <h2 class="text-gray-900 font-semibold mb-3">Karbantartók elérhetősége</h2>-->

<!--                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">-->
<!--                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">-->
<!--                        <tr>-->
<!--                            <th scope="col" class="px-6 py-3">-->
<!--                                Név-->
<!--                            </th>-->
<!--                            <th scope="col" class="px-6 py-3">-->
<!--                                Státusz-->
<!--                            </th>-->
<!--                            <th scope="col" class="px-6 py-3">-->
<!--                                Státusz kezdete-->
<!--                            </th>-->
<!--                            <th scope="col" class="px-6 py-3">-->
<!--                                Státusz vége-->
<!--                            </th>-->
<!--                            <th scope="col" class="px-6 py-3">-->
<!--                                <span class="sr-only">Edit</span>-->
<!--                            </th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        <tr v-for="order in props.orders" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">-->
<!--                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">-->
<!--                                {{ order.worker.name }}-->
<!--                            </th>-->
<!--                            <td class="px-6 py-4">-->
<!--                                {{ order.status }}-->
<!--                            </td>-->
<!--                            <td class="px-6 py-4">-->
<!--                                {{ order.start_status }}-->
<!--                            </td>-->
<!--                            <td class="px-6 py-4">-->
<!--                                {{ order.end_status }}-->
<!--                            </td>-->
<!--                            <td class="px-6 py-4 text-right">-->
<!--&lt;!&ndash;                                <button&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="handleClicked(worker)"&ndash;&gt;-->
<!--&lt;!&ndash;                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <i class="fa-regular fa-calendar-days mr-1.5 opacity-75"></i>&ndash;&gt;-->
<!--&lt;!&ndash;                                    Beosztás&ndash;&gt;-->
<!--&lt;!&ndash;                                </button>&ndash;&gt;-->
<!--                            </td>-->
<!--                        </tr>-->

<!--                        </tbody>-->
<!--                    </table>-->
<!--                </div>-->
            </div>
        </div>
        </Transition>



    </AuthenticatedLayout>
</template>
