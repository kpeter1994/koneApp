<script setup>
import {computed, defineProps, onMounted, ref} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {onClickOutside} from '@vueuse/core'
import {formater} from "@/utils.js";
import NativeLink from "@/Components/NativeLink.vue";
import axios from "axios";
import NoAvailableTable from "@/Components/tables/NoAvailableTable.vue";

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
                <div class="bg-white shadow rounded-2xl p-6 mb-6 flex justify-between flex-wrap gap-3">

                    <div>
                        <table class="rounded-2xl overflow-hidden bg-slate-50 shadow">
                            <tr>
                                <th class="bg-blue-700 text-white uppercase" colspan="8">{{formater.getActualMountName()}}</th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="p-3 text-center"></th>
                                <th rowspan="2" class="p-3 text-center"></th>
                                <th class="p-3 text-center bg-green-100" colspan="2">Nappal ügyelet</th>
                                <th class="p-3 text-center bg-green-200">Délután ügyelet</th>
                                <th class="p-3 text-center bg-blue-100">Mozgólépcső ügyelet </th>
                                <th class="p-3 text-center bg-purple-100">Épülettechnika ügyelet</th>
                                <th class="p-3 text-center bg-purple-200">Debrecen és környéke ügyelet</th>
                            </tr>
                            <tr>
                                <td class="text-center bg-green-100">1. nappalos</td>
                                <td class="text-center bg-green-100">2. nappalos</td>
                                <td class="text-center bg-green-200">3. délutános</td>
                                <td class="text-center bg-blue-100 "></td>
                                <td class="text-center bg-purple-100"></td>
                                <td class="text-center bg-purple-200"></td>
                            </tr>
                            <tr v-for="(dateArray, index) in props.orders" :key="index" :class="formater.isToday(index) ? 'border border-green-500' : '' ">
                                <td class="p-3">{{formater.getDate(index)}}</td>
                                <td class="p-3">{{formater.getDayName(index)}}</td>
                                <td class="p-3 text-center bg-green-100">{{addDuty('Délelötti ügyeletes',dateArray, true, 0)}}</td>
                                <td class="p-3 text-center bg-green-100">{{addDuty('Délelötti ügyeletes',dateArray, true, 1)}}</td>
                                <td class="p-3 text-center bg-green-200">{{addDuty('Délutáni ügyeletes',dateArray)}}</td>
                                <td class="p-3 text-center bg-blue-100">{{addDuty('Mozgólépcső ügyeletes',dateArray)}}</td>
                                <td class="p-3 text-center bg-purple-100">{{addDuty('Épülettechnika ügyeletes',dateArray)}}</td>
                                <td class="p-3 text-center bg-purple-200">{{addDuty('Debrecen',dateArray)}}</td>
                            </tr>
                        </table>
                    </div>



                    <div class="w-1/5 flex flex-col gap-3">
                        <NoAvailableTable :day="0"></NoAvailableTable>
                        <NoAvailableTable :day="1"></NoAvailableTable>
                        <NoAvailableTable :day="2"></NoAvailableTable>
                        <NoAvailableTable :day="3"></NoAvailableTable>
                    </div>






                </div>
            </div>
        </div>
        </Transition>



    </AuthenticatedLayout>
</template>
