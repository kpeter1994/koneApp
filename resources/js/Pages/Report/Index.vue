<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TimelineComponent from "@/Components/partials/TimelineComponent.vue";



</script>

<template>
    <Head title="Statisztikák" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-chart-bar opacity-75 mr-1.5"></i>Statisztikák</h2>
        </template>

        <div class="py-6 px-3">
            <div class="mx-auto sm:px-6 lg:px-8">
              <TimelineComponent></TimelineComponent>


            </div>
        </div>


    </AuthenticatedLayout>
</template>
