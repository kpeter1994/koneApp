<script setup>
import InputLabel from "@/Components/form/InputLabel.vue";
import AutoComplete from "primevue/autocomplete";
import {reactive, ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import axios from 'axios';
import NativeLink from "@/Components/NativeLink.vue";


const props = defineProps({
    dalyReport: Object
})

const originalItems = ['Badar Csaba', 'Gábor Tamás', 'Gila József', 'Bence Zsolt', 'Helfrut György', 'Nagy Csaba', 'Nagy Imre', 'Nincs Ügyeletes', 'Ozsváth Tibor', 'Pallás Lajos', 'Sápi Jenő', 'Veres Imre', 'Vida Zoltán', 'Babarczi Balázs', 'Barabás Gy.', 'Grész Csaba', 'Horváth László', 'Hosszú Károly', 'Kovács Csaba', 'Kovács Nóra', 'Martyán Béla', 'Nem jelentkezett be', 'Németh István', 'Barta Attila', 'Bédi János', 'Bognár István', 'Borbély Ferenc', 'Bovier Zsolt', 'Fehér Pál', 'Kuruc Milán', 'Orbán Szabolcs', 'Sikari Dániel', 'Szabó László', 'Szirmai Zsombor', 'Tóth Dániel', 'Tornyi Gábor', 'Török Péter', 'Tuman Károly'];

const items = ref([...originalItems])
const search = (event) => {
    // Az eredeti lista alapján szűrjük a keresési kifejezést tartalmazó elemeket
    items.value = originalItems.filter(item =>
        item.toLowerCase().includes(event.query.toLowerCase())
    );
};

const form = reactive({

    d_solo_demand: props.dalyReport.d_solo_demand,
    d_articulated_demand: props.dalyReport.d_articulated_demand,
    d_solo_supply: props.dalyReport.d_solo_supply,
    d_articulated_supply: props.dalyReport.d_articulated_supply,
    b_solo_demand: props.dalyReport.b_solo_demand,
    b_articulated_demand: props.dalyReport.b_articulated_demand,
    b_solo_supply: props.dalyReport.b_solo_supply,
    b_articulated_supply: props.dalyReport.b_articulated_supply,

    k_solo_demand: props.dalyReport.k_solo_demand,
    k_articulated_demand: props.dalyReport.k_articulated_demand,
    k_sprinter_demand: props.dalyReport.k_sprinter_demand,
    k_solo_supply: props.dalyReport.k_solo_supply,
    k_articulated_supply: props.dalyReport.k_articulated_supply,
    k_sprinter_supply: props.dalyReport.k_sprinter_supply,

    // helyi garázsmesterek
    d_start_worker: props.dalyReport.d_start_worker,
    d_middle_worker: props.dalyReport.d_middle_worker,
    d_end_worker: props.dalyReport.d_end_worker,

    b_start_worker: props.dalyReport.b_start_worker,
    b_middle_worker: props.dalyReport.b_middle_worker,
    b_end_worker: props.dalyReport.b_end_worker,

    k_start_worker: props.dalyReport.k_start_worker,
    k_middle_worker: props.dalyReport.k_middle_worker,
    k_end_worker: props.dalyReport.k_end_worker,

    info_error: props.dalyReport.info_error,
    firewall_attack: props.dalyReport.firewall_attack,
})

const garages = [
    {
        location: 'Debrecen',
        customer: 'DKV',
        busType1: 'szólót',
        busType2: 'csulkóst',
        soloDemand: 'd_solo_demand',
        articulatedDemand: 'd_articulated_demand',
        soloSupply: 'd_solo_supply',
        articulatedSupply: 'd_articulated_supply',
        startWorker: 'd_start_worker',
        middleWorker: 'd_middle_worker',
        endWorker: 'd_end_worker'

    },
    {
        location: 'Kecskemét',
        customer: 'Kecskemét',
        busType1: 'szólót',
        busType2: 'csulkóst',
        busType3: 'sprinter',
        soloDemand: 'k_solo_demand',
        articulatedDemand: 'k_articulated_demand',
        articulatedSupply: 'k_articulated_supply',
        sprinterDemand: 'k_sprinter_demand',
        soloSupply: 'k_solo_supply',
        sprinterSupply: 'k_sprinter_supply',
        startWorker: 'k_start_worker',
        middleWorker: 'k_middle_worker',
        endWorker: 'k_end_worker'
    },
    {
        location: 'Budapest',
        customer: 'BKK',
        busType1: 'szólót',
        busType2: 'csulkóst',
        soloDemand: 'b_solo_demand',
        articulatedDemand: 'b_articulated_demand',
        soloSupply: 'b_solo_supply',
        articulatedSupply: 'b_articulated_supply',
        startWorker: 'b_start_worker',
        middleWorker: 'b_middle_worker',
        endWorker: 'b_end_worker'
    },

]

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}


const submitForm = debounce(() => {
    axios.patch(route('daily-report.update',props.dalyReport.id), form)
    console.log("Form data is being sent...", form);

},900)

watch(form, () => {
    submitForm()
}, {deep: true})


</script>

<template>
    <div class="lg:w-1/2 p-6 bg-white rounded-2xl shadow text-gray-700">
        <table v-for="garage in garages" class=" w-full mb-6">
            <tr>
                <th colspan="3" class="p-1.5 bg-gray-100 uppercase text-sm">{{garage.location}} buszüzemeltetés</th>
            </tr>
            <tr>
                <td class="p-1.5">{{garage.customer}} kért:</td>
                <td><input class="rounded" v-model="form[garage.soloDemand]" type="text"></td>
                <td>db {{garage.busType1}}</td>
            </tr>
            <tr class="mb-6">
                <td class="p-1.5">Mi adtunk ki:</td>
                <td><input v-model="form[garage.soloSupply]" class="rounded" type="text"></td>
                <td>db {{garage.busType1}}</td>
            </tr>
            <tr>
                <th colspan="3" class="p-1.5 "></th>
            </tr>
            <tr>
                <td class="p-1.5">{{garage.customer}} kért:</td>
                <td><input class="rounded" v-model="form[garage.articulatedDemand]" type="text"></td>
                <td>db {{garage.busType2}}</td>
            </tr>

            <tr class="pt-6">
                <td class="p-1.5">Mi adtunk ki:</td>
                <td><input class="rounded" v-model="form[garage.articulatedSupply]" type="text"></td>
                <td>db {{garage.busType2}}</td>
            </tr>
            <tr v-if="garage.busType3">
                <td class="p-1.5">{{garage.customer}} kért:</td>
                <td><input class="rounded" v-model="form[garage.sprinterDemand]" type="text"></td>
                <td>db {{garage.busType3}}</td>
            </tr>
            <tr v-if="garage.busType3" class="mb-6">
                <td class="p-1.5">Mi adtunk ki:</td>
                <td><input class="rounded" v-model="form[garage.sprinterSupply]" type="text"></td>
                <td>db {{garage.busType3}}</td>
            </tr>

            <tr>
                <th colspan="3" class="p-1.5 uppercase text-sm">Szolgálatban</th>
            </tr>

            <tr>
                <td>
                    <InputLabel>Bejelentő</InputLabel>
                    <AutoComplete class="rounded" v-model="form[garage.startWorker]" dropdown :suggestions="items" @complete="search" />
                </td>
                <td>
                    <InputLabel>Bejelentő</InputLabel>
                    <AutoComplete class="rounded" v-model="form[garage.middleWorker]" dropdown :suggestions="items" @complete="search" />
                </td>
                <td>
                    <InputLabel>Bejelentő</InputLabel>
                    <AutoComplete class="rounded" v-model="form[garage.endWorker]" dropdown :suggestions="items" @complete="search" />
                </td>
            </tr>
        </table>

        <table class="w-full">
            <tr>
                <td>Informatikai hibák</td>
                <td>Tűzfal támadások</td>
            </tr>
            <tr class="w-full">
                <td class=""><input class="rounded w-full" v-model="form.info_error" type="text"></td>

                <td class=""><input class="rounded w-full" v-model="form.firewall_attack" type="text"></td>
            </tr>
        </table>

        <div class="mt-6">

            <native-link :href="route('sendReport')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Jelentés elküldése</native-link>

        </div>
    </div>
</template>

<style scoped>

</style>
