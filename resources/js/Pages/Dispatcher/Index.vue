<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ToastComponent from "@/Components/notification/ToastComponent.vue";
import NativeLink from "@/Components/NativeLink.vue";
import { ref } from 'vue';
import axios  from "axios";
import DalyReportForm from "@/Pages/Dispatcher/components/dalyReportForm.vue";
import {formater} from "@/utils.js";



const props = defineProps({
    flash: Object,
    events: Object,
    dalyReport: Object
});

const filterEvents = (location) => {
    return props.events.filter(event => event.location === location);
}

const openReport = () => {
    axios.post('/daily-report').then(response => {
        window.location.reload();
    }).catch(error => {
        console.error("Hiba történt az adatok lekérésekor:", error);
    });
}

const message = ref('');
const sendMail = (id) => {
    axios.post(`/send-event/${id}`, {id: id})
        .then(response => {
            console.log("Response received:", response);
            message.value = response.data;
        })
        .catch(error => {
            console.error("Error sending data:", error);
        });
    console.log("Form data is being sent...", id);
}

const deleteEvent = (id) => {
    if (confirm("Biztosan törölni szeretné az eseményt?")) {
        axios.delete(`/delete-event/${id}`)
            .then(response => {
                console.log("Response received:", response);
                window.location.reload();
                message.value = response.data;
            })
            .catch(error => {
                console.error("Error sending data:", error);
            });
        console.log("Form data is being sent...", id);
    }
}



</script>

<template>
    <Head title="Főügyelet" />

    <AuthenticatedLayout>

        <template #toast>
            <ToastComponent :flash="message"></ToastComponent>
        </template>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-bus opacity-75 mr-1.5"></i>
                Főügyelet</h2>
        </template>

        <Transition name="slide-up" appear>
            <div class="py-6 px-3">
                <div class="flex gap-6">

                    <div v-if="!dalyReport" class="w-full bg-white p-6">
                        <Button class="p-3 bg-blue-500 text-white rounded hover:bg-blue-400" @click="openReport()">Nap megnyitása</Button>
                    </div>
                    <div v-if="dalyReport" class="lg:w-1/2 p-6 bg-white rounded-2xl shadow text-gray-700">
                        <div class="flex justify-between">
                            <h1 class="text-center font-semibold">Fődiszpécser napi üzemviteli jelentés - {{formater.formatDateNormal(dalyReport.created_at)}}</h1>

                            <NativeLink :href="route('fougyelet.create')" class="bg-blue-500 text-white px-3 py-1 rounded-md">Új esemény</NativeLink>

                        </div>


                        <table class="w-full mt-6">
                            <tr class="border-b border-gray-100">
                                <th class="p-1.5" colspan="2">Balesetek, elemi károk (tűz, csőtörés, villámcsapás, …), hatósági ellenőrzés</th>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <th class="p-1.5">Esmény leírása</th>
                                <th class="p-1.5">Tett intézkedés</th>
                                <th>Művelet</th>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2">Budapest, Óradna u.5.</td>
                            </tr>
                            <tr v-for="event in filterEvents('Budapest, Óradna u.5.')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                                <td class="flex justify-center items-center gap-2">
                                    <button @click="sendMail(event.id)">
                                        <i class="fa-solid fa-envelope"></i>
                                    </button>

                                    <NativeLink :href="route('editEvent', {id: event.id})" >
                                        <i class="fa-solid fa-pen"></i>
                                    </NativeLink>

                                    <button @click="deleteEvent(event.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>



                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2"> Budapest, Óbuda BKV garázs</td>
                            </tr>
                            <tr v-for="event in filterEvents('Budapest, Óbuda BKV garázs')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                                <td class="flex justify-center items-center gap-2">
                                    <button @click="sendMail(event.id)">
                                        <i class="fa-solid fa-envelope"></i>
                                    </button>

                                    <NativeLink :href="route('editEvent', {id: event.id})" >
                                        <i class="fa-solid fa-pen"></i>
                                    </NativeLink>

                                    <button @click="deleteEvent(event.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>


                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2">Debrecen, Kígyóhagyma u.</td>
                            </tr>
                            <tr v-for="event in filterEvents('Debrecen, Kígyóhagyma u.')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                                <td class="flex justify-center items-center gap-2">
                                    <button @click="sendMail(event.id)">
                                        <i class="fa-solid fa-envelope"></i>
                                    </button>

                                    <NativeLink :href="route('editEvent', {id: event.id})" >
                                        <i class="fa-solid fa-pen"></i>
                                    </NativeLink>

                                    <button @click="deleteEvent(event.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2">Kecskemét, Georg Knorr u.</td>
                            </tr>
                            <tr v-for="event in filterEvents('Kecskemét, Georg Knorr u.')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                                <td class="flex justify-center items-center gap-2">
                                    <button @click="sendMail(event.id)">
                                        <i class="fa-solid fa-envelope"></i>
                                    </button>

                                    <NativeLink :href="route('editEvent', {id: event.id})" >
                                        <i class="fa-solid fa-pen"></i>
                                    </NativeLink>

                                    <button @click="deleteEvent(event.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                        </table>

                    </div>
                    <DalyReportForm :dalyReport="props.dalyReport" v-if="props.dalyReport"/>
                </div>

            </div>
        </Transition>

    </AuthenticatedLayout>
</template>

<style>

</style>
