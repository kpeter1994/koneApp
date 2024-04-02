<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ToastComponent from "@/Components/notification/ToastComponent.vue";
import MolLogo from "@/Components/image/MolLogo.vue";
import NativeLink from "@/Components/NativeLink.vue";
import NavLink from "@/Components/NavLink.vue";
import AutoComplete from "primevue/autocomplete";
import InputLabel from "@/Components/form/InputLabel.vue";
import { ref } from 'vue';
import axios  from "axios";
import { router } from '@inertiajs/vue3'


const props = defineProps({
    flash: Object,
    events: Object,
    dalyReport: Object
});

const filterEvents = (location) => {
    return props.events.filter(event => event.location === location);
}

const originalItems = ['Badar Csaba', 'Gábor Tamás', 'Gila József', 'Helfrut György', 'Nagy Csaba', 'Nagy Imre', 'Nincs Ügyeletes', 'Ozsváth Tibor', 'Pallás Lajos', 'Sápi Jenő', 'Veres Imre', 'Vida Zoltán', 'Babarczi Balázs', 'Barabás Gy.', 'Grész Csaba', 'Horváth László', 'Hosszú Károly', 'Kovács Csaba', 'Kovács Nóra', 'Martyán Béla', 'Nem jelentkezett be', 'Németh István', 'Barta Attila', 'Bédi János', 'Bognár István', 'Borbély Ferenc', 'Bovier Zsolt', 'Fehér Pál', 'Kuruc Milán', 'Orbán Szabolcs', 'Sikari Dániel', 'Szabó László', 'Szirmai Zsombor', 'Tóth Dániel', 'Tornyi Gábor', 'Török Péter', 'Tuman Károly'];



const items = ref([...originalItems])

const search = (event) => {
    // Az eredeti lista alapján szűrjük a keresési kifejezést tartalmazó elemeket
    items.value = originalItems.filter(item =>
        item.toLowerCase().includes(event.query.toLowerCase())
    );
};

const openReport = () => {
    axios.post('/daily-report').then(response => {
        window.location.reload();
    }).catch(error => {
        console.error("Hiba történt az adatok lekérésekor:", error);
    });
}



</script>

<template>
    <Head title="MOL Plugge" />

    <AuthenticatedLayout>

        <template #toast>
            <ToastComponent :flash="props.flash"></ToastComponent>
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
                            <h1 class="text-center font-semibold">Fődiszpécser napi üzemviteli jelentés - 2024. Március 05.</h1>

                            <NativeLink :href="route('fougyelet.create')" class="bg-blue-500 text-white px-3 py-1 rounded-md">Új esemény</NativeLink>

                        </div>


                        <table class="w-full mt-6">
                            <tr class="border-b border-gray-100">
                                <th class="p-1.5" colspan="2">Balesetek, elemi károk (tűz, csőtörés, villámcsapás, …), hatósági ellenőrzés</th>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <th class="p-1.5">Esmény leírása</th>
                                <th class="p-1.5">Tett intézkedés</th>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2">Budapest, Istvántelki u.8.</td>
                            </tr>
                            <tr v-for="event in filterEvents('Budapest, Istvántelki u.8.')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                            </tr>



                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2"> Budapest, Óbuda BKV garázs</td>
                            </tr>
                            <tr v-for="event in filterEvents('Budapest, Óbuda BKV garázs')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                            </tr>


                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2">Debrecen, Kígyóhagyma u.</td>
                            </tr>
                            <tr v-for="event in filterEvents('Debrecen, Kígyóhagyma u.')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                            </tr>

                            <tr class="border-b border-gray-100">
                                <td class="p-1.5 font-semibold opacity-60" colspan="2">Kecskemét, Georg Knorr u.</td>
                            </tr>
                            <tr v-for="event in filterEvents('Kecskemét, Georg Knorr u.')">
                                <td class="p-1.5">{{event.name}}</td>
                                <td class="p-1.5">{{event.description}}</td>
                            </tr>


                        </table>


                    </div>
                    <div v-if="dalyReport" class="lg:w-1/2 p-6 bg-white rounded-2xl shadow text-gray-700">
                        <table class=" w-full">
                            <tr>
                                <th colspan="3" class="p-1.5 bg-gray-100 uppercase text-sm">Debrecen buszüzemeltetés</th>
                            </tr>
                            <tr>
                                <td class="p-1.5">DKV kért:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr class="mb-6">
                                <td class="p-1.5">Mi adtunk ki:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="p-1.5 "></th>
                            </tr>
                            <tr>
                                <td class="p-1.5">DKV kért:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr class="mb-6">
                                <td class="p-1.5">Mi adtunk ki:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="p-1.5 uppercase text-sm">Szolgálatban</th>
                            </tr>

                            <tr>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>

                            </tr>
                        </table>
                        <table class=" mt-6 w-full">
                            <tr>
                                <th colspan="3" class="p-1.5 bg-gray-100 uppercase text-sm">Debrecen buszüzemeltetés</th>
                            </tr>
                            <tr>
                                <td class="p-1.5">DKV kért:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr class="mb-6">
                                <td class="p-1.5">Mi adtunk ki:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="p-1.5 "></th>
                            </tr>
                            <tr>
                                <td class="p-1.5">DKV kért:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr class="mb-6">
                                <td class="p-1.5">Mi adtunk ki:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="p-1.5 uppercase text-sm">Szolgálatban</th>
                            </tr>

                            <tr>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>

                            </tr>
                        </table>
                        <table class=" mt-6 w-full">
                            <tr>
                                <th colspan="3" class="p-1.5 bg-gray-100 uppercase text-sm">Debrecen buszüzemeltetés</th>
                            </tr>
                            <tr>
                                <td class="p-1.5">DKV kért:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr class="mb-6">
                                <td class="p-1.5">Mi adtunk ki:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="p-1.5 "></th>
                            </tr>
                            <tr>
                                <td class="p-1.5">DKV kért:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr class="mb-6">
                                <td class="p-1.5">Mi adtunk ki:</td>
                                <td><input class="rounded" type="text"></td>
                                <td>db szólót</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="p-1.5 uppercase text-sm">Szolgálatban</th>
                            </tr>

                            <tr>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>
                                <td>
                                    <InputLabel>Bejelentő</InputLabel>
                                    <AutoComplete class="rounded" v-model="value" dropdown :suggestions="items" @complete="search" />
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </Transition>

    </AuthenticatedLayout>
</template>

<style>

</style>
