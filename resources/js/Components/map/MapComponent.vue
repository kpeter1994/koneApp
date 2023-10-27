<script setup>
import {onMounted, ref, watch, nextTick} from "vue";
import L from 'leaflet';
import {onClickOutside} from "@vueuse/core";
import {formatTime} from "@/utils.js";
import axios from "axios";
import LoadingComponent from "@/Components/form/LoadingComponent.vue";

const errorsByWorker = ref(null)
const loading = ref(false)
let geoCoordinates = ref([]);
const target = ref(null)
const mapVisible = ref(false);

const close = () => mapVisible.value = false


onMounted(async () => {
    try {
        const response = await axios.get('/api/error-by-workers');
        errorsByWorker.value = response.data;

        geoCoordinates.value = Object.values(errorsByWorker.value).map((worker) => {
            return worker.map((error) => {
                return {
                    lat: error.equipment.lat,
                    lng: error.equipment.lng,
                    troubleshooter: error.troubleshooter,
                    address: error.equipment.address,
                    createdAt: error.created_at
                };
            });
        });

        // console.log(errorsByWorker.value);
        loading.value = true


    } catch (error) {
        console.error(error);
    }
})


watch(mapVisible, async (newValue) => {
    if (newValue && geoCoordinates.value.length) {
        await nextTick();


        // Térkép inicializálása
        const map = L.map('map').setView([47.5079169, 19.0795471], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const colors = ['blue', 'red', 'green', 'purple', 'orange', 'darkred', 'darkblue', 'darkgreen', 'darkpurple', 'cadetblue'];



        geoCoordinates.value.forEach((coordsForWorker, workerIndex) => {
            const workersArray = Object.values(errorsByWorker.value)[workerIndex];
            coordsForWorker.forEach((coord, coordIndex) => {
                const worker = workersArray[coordIndex];

                const markerIcon = L.divIcon({
                    className: 'fa-solid fa-toolbox',
                    html: ` <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="15.5" cy="13.5" r="7.5" fill="white"/>
                            <path d="M16 2.66667C10.1187 2.66667 5.33336 7.452 5.33336 13.3267C5.29469 21.92 15.5947 29.0453 16 29.3333C16 29.3333 26.7054 21.92 26.6667 13.3333C26.6667 7.45201 21.8814 2.66667 16 2.66667ZM16 18.6667C13.0534 18.6667 10.6667 16.28 10.6667 13.3333C10.6667 10.3867 13.0534 8 16 8C18.9467 8 21.3334 10.3867 21.3334 13.3333C21.3334 16.28 18.9467 18.6667 16 18.6667Z" fill="${colors[workerIndex % colors.length]}"/>
                            </svg>`,
                    iconSize: [10, 10]
                });
                L.marker([coord.lat, coord.lng], { icon: markerIcon }).addTo(map)
                    .bindPopup(`${coord.troubleshooter}<br>${coord.address}<br>${formatTime(coord.createdAt)}`)
                    .openPopup();
            });
        });


        // Frissítsd a térkép méretét
        map.invalidateSize();
    }
});

onClickOutside(target, close)

</script>

<template>
    <button @click="mapVisible = true"
            class="w-8 h-8 flex justify-center items-center bg-blue-50 rounded text-blue-900">
        <i class="fa-solid fa-map"></i>
    </button>

    <transition name="fade">
        <div v-if="mapVisible"
             class="fixed top-0 left-0 bg-gray-900 w-full h-screen z-40 flex justify-center items-center bg-opacity-25 backdrop-blur p-3">

            <LoadingComponent loading-message="Térkép betöltése..." v-if="!loading" />
            <div v-if="loading" ref="target" id="map" class="border border-gray-900 w-full xl:w-[1200px] h-[800px]"></div>
        </div>
    </transition>


</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.1s;
}
.fade-enter-from, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
}
.fade-enter-to, .fade-leave-from /* .fade-enter-active in <2.1.8 */ {
    opacity: 1;
}
</style>
