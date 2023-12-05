<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,} from '@inertiajs/vue3';
import {formatDate, formatTime} from "@/utils.js";
import {defineProps, ref, watch} from "vue";
import axios from "axios";
import InfiniteScrollComponent from "@/Components/partials/InfiniteScrollComponent.vue";


const props = defineProps({
    errors: Object,
    flash: Object
});
const filtered = ref(false);

const contractTel = ref(null);
const contractName = ref('Kattints a karbantartóra a telefonszámért!');

const showMessages = ref(true);

const getContract = (contract) => {
    axios.get(route('workers.show', {name: contract}))
        .then(response => {
            contractTel.value = response.data.tel
            contractName.value = response.data.name
        })
        .catch(error => {
            console.log(error)
        })
}



</script>

<template>
    <Head title="Hibabejelentések"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-yellow-500 text-xl  dark:text-gray-200 leading-tight transition-all"><i
                class="fa-solid fa-toolbox mr-1.5"></i>Hibabejenetések</h2>
        </template>


        <div class="py-6">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                    <div class="flex justify-between items-center">
                        <div class="p-1">
                            <input @click="!filtered" type="checkbox" id="filtered" name="filtered" v-model="filtered" class="mr-2 cursor-pointer">
                            <label for="filtered">Csak kiadandó</label>
                        </div>
                        <div class="relative">
                            <div v-if="props.flash.success && showMessages" class="absolute bg-green-100 p-3 gap-6 flex rounded items-center">
                                <p><i class="fa-solid fa-circle-info mr-1.5"></i>{{props.flash.success}}</p>
                                <i @click="showMessages = false" class="fa-solid fa-xmark cursor-pointer"></i>
                            </div>
                            <div class="flex justify-end items-center mb-3 text-green-900">


                                <div class="p-3 bg-blue-100 mr-3 rounded ">
                                    {{contractName}}
                                    <span class="font-semibold">
                                    {{contractTel}}
                                </span>
                                </div>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-magnifying-glass absolute ml-3 pointer-events-none z-30"></i>
                                    <input
                                        class="rounded-lg pl-8"
                                        type="text"
                                        v-model="search">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
                            <thead
                                class="text-xs text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Hibajegy száma
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Dátum
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Bejelentés Időpontja
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Szerződés szám
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Partner neve
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Beépítési cím
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Berendezés típusa
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Equipment
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    ÉMI szám
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Karbantartó
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Hiba elhárító karbantartó
                                </th>
                                <th scope="col" class="p-1.5 w-[100px]">
                                    Hibajelenség leírása (Bejelentő)
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Hiba típusa
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Áll-e a lift?
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Hány sérült van?
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Diszpécser neve
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Bejelentő
                                </th>
                                <th scope="col" class="p-1.5 w-[50px]">
                                    Bejelentő telefonszáma
                                </th>
                                <th scope="col" class="p-1.5">
                                    megjegyzés, észrevétel
                                </th>
                                <th scope="col" class="p-1.5">
                                    Művelet
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="error in props.errors"
                                :class="error.troubleshooter && error.troubleshooter.includes('kiadandó') ? 'bg-yellow-200 dark:bg-red-700' : 'bg-white dark:bg-gray-800'"
                                class="border-b dark:bg-gray-800 dark:border-gray-700">

                                <td class="p-1.5 text-center">
                                    {{ error.error_number }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ formatDate(error.created_at) }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ formatTime(error.created_at) }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.contract_ref }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.name }}
                                </td>
                                <td class="p-1.5 text-center min-w-64">
                                    {{ error.address }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.type }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.equipment }}
                                </td>
                                <td class="p-1.5 text-center whitespace-nowrap">
                                    {{ error.emi }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.worker }}
                                </td>
                                <td class="p-1.5 text-center cursor-pointer text-blue-500" @click="getContract(error.troubleshooter)">
                                    {{ error.troubleshooter }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.description }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.error_type }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.isStand }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.injured }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.dispatcher }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.whistleblower }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.whistleblower_tel }}
                                </td>
                                <td class="p-1.5 text-center">
                                    {{ error.comment }}
                                </td>


                                <td class="px-6 py-4 text-right">
                                    <a
                                        :href="route('error.edit', error.id)"
                                        class="font-medium text-blue-500 dark:text-blue-500 flex items-center whitespace-nowrap">
                                        <i class="fa-solid fa-pen mr-1.5 text-center opacity-75"></i>
                                        Szerkesztés
                                    </a>
                                </td>
                            </tr>

                            <InfiniteScrollComponent :data="props.errors">
                                <template v-slot:default="{item}">
                                    <tr :class="item.troubleshooter && item.troubleshooter.includes('kiadandó') ? 'bg-yellow-200 dark:bg-red-700' : 'bg-white dark:bg-gray-800'"
                                        class="border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="p-1.5 text-center">
                                            {{ item.error_number }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ formatDate(item.created_at) }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ formatTime(item.created_at) }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.contract_ref }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.name }}
                                        </td>
                                        <td class="p-1.5 text-center min-w-64">
                                            {{ item.address }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.type }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.equipment }}
                                        </td>
                                        <td class="p-1.5 text-center whitespace-nowrap">
                                            {{ item.emi }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.worker }}
                                        </td>
                                        <td class="p-1.5 text-center cursor-pointer text-blue-500" @click="getContract(item.troubleshooter)">
                                            {{ item.troubleshooter }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.description }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.error_type }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.isStand }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.injured }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.dispatcher }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.whistleblower }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.whistleblower_tel }}
                                        </td>
                                        <td class="p-1.5 text-center">
                                            {{ item.comment }}
                                        </td>


                                        <td class="px-6 py-4 text-right">
                                            <a
                                                :href="route('error.edit', item.id)"
                                                class="font-medium text-blue-500 dark:text-blue-500 flex items-center whitespace-nowrap">
                                                <i class="fa-solid fa-pen mr-1.5 text-center opacity-75"></i>
                                                Szerkesztés
                                            </a>
                                        </td>
                                    </tr>
                                </template>
                            </InfiniteScrollComponent>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
