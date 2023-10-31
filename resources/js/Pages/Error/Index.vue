<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import ErrorForm from "@/Components/partials/ErrorForm.vue";
import {formatDate, formatTime} from "@/utils.js";
import NavLink from "@/Components/NavLink.vue";
import {defineProps, ref} from "vue";


const props = defineProps({
    errors: Object,
    flash: Object
});

const showMessages = ref(true);

console.log(props.errors)
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-yellow-500 text-xl  dark:text-gray-200 leading-tight transition-all"><i
                class="fa-solid fa-toolbox mr-1.5"></i>Hibabejenetések</h2>
        </template>


        <div class="py-6">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="relative">
                        <div v-if="props.flash.success && showMessages" class="absolute bg-green-100 p-3 gap-6 flex rounded items-center">
                            <p><i class="fa-solid fa-circle-info mr-1.5"></i>{{props.flash.success}}</p>
                            <i @click="showMessages = false" class="fa-solid fa-xmark cursor-pointer"></i>
                        </div>
                        <div class="flex justify-end items-center mb-3 text-green-900">

                            <div class="relative flex items-center">
                                <i class="fa-solid fa-magnifying-glass absolute ml-3 pointer-events-none z-30"></i>
                                <input
                                    class="rounded-lg pl-8"
                                    type="text"
                                    v-model="search">
                            </div>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-3 py-3">
                                    Hibajegy száma
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Dátum
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Bejelentés Időpontja
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Szerződésszám
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Partner neve
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Beépítési cím
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Berendezés típusa
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Equipment
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    ÉMI szám
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Karbantartó
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Hiba elhárító karbantartó
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Hibajelenség leírása (Bejelentő)
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Hiba típusa
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Áll-e a lift?
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Hány sérült van?
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Diszpécser neve
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Bejelentő
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Bejelentő telefonszáma
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    megjegyzés, észrevétel
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Művelet
                                </th>


                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="error in props.errors"
                                :class="error.troubleshooter.includes('kiadandó') ? 'bg-yellow-200 dark:bg-red-700' : 'bg-white dark:bg-gray-800'"
                                class="border-b dark:bg-gray-800 dark:border-gray-700">

                                <td class="px-6 py-4">
                                    {{ error.error_number }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ formatDate(error.created_at) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ formatTime(error.created_at) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.equipment.contract_ref }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.equipment.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.equipment.address }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.equipment.type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.equipment.equipment }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.equipment.emi }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.equipment.worker }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.troubleshooter }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.description }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.error_type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.isStand }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.injured }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.dispatcher }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.whistleblower }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.whistleblower_tel }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ error.comment }}
                                </td>


                                <td class="px-6 py-4 text-right">
                                    <a
                                        :href="route('error.edit', error.id)"
                                        class="font-medium text-blue-500 dark:text-blue-500 flex items-center whitespace-nowrap">
                                        <i class="fa-solid fa-pen mr-1.5 opacity-75"></i>
                                        Szerkesztés
                                    </a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
