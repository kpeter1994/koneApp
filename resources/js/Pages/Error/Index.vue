<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import ErrorForm from "@/Components/partials/ErrorForm.vue";
import {formatDate, formatTime} from "@/utils.js";


const props = defineProps({
    errors: Object
});

console.log(props.errors)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Berendezések</h2>
        </template>

        <div class="py-6">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2>Hibabejelentések</h2>
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <spant>text</spant>
                            <div class="relative flex items-center">
                                <i class="fa-solid fa-magnifying-glass absolute ml-3 pointer-events-none z-30"></i>
                                <input
                                    class="rounded-lg pl-8"
                                    type="text"
                                    v-model="search">
                            </div>
                        </div>
                    </div>

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Hibajegy száma
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Dátum
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Bejelentés Időpontja
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Szerződésszám
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Partner neve
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Beépítési cím
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Equipment
                            </th>
                            <th scope="col" class="px-6 py-3">
                                ÉMI szám
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Berendezés típusa
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
                                Inventory number
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Megjegyzés
                            </th>
                            <th scope="col" class="px-6 py-3">

                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="error in props.errors" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                {{error.error_number}}
                            </td>
                            <td class="px-6 py-4">
                                {{formatDate(error.created_at)}}
                            </td>
                            <td class="px-6 py-4">
                                {{formatTime(error.created_at)}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.equipment.contract_ref}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.equipment.name}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.equipment.address}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.equipment.type}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.equipment.equipment}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.equipment.emi}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.equipment.worker}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.troubleshooter}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.description}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.troubleshooter}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.troubleshooter}}
                            </td>
                            <td class="px-6 py-4">
                                {{error.troubleshooter}}
                            </td>

                            <td class="px-6 py-4 text-right">
<!--                                <button-->
<!--                                    @click="handleClicked(equipment)"-->
<!--                                    class="font-medium text-yellow-500 dark:text-blue-500 hover:underline flex items-center whitespace-nowrap">-->
<!--                                    <i class="fa-solid fa-wrench mr-1.5 opacity-75"></i>-->
<!--                                    Hiba bejelentés-->
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
