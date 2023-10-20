<script setup>
import {onMounted, ref, watch, nextTick} from "vue";
import L from 'leaflet';
import {onClickOutside} from "@vueuse/core";
import {geocodeAddress} from "@/utils.js";

const target = ref(null)
const mapVisible = ref(false);
const close = () => mapVisible.value = false


let address1 = ref(null)

onMounted(async () => {
    address1.value = await geocodeAddress('PETŐFI TÉR 4-6., GÖDÖLLŐ')
    console.log(address1.value);
})

console.log(address1)

watch(mapVisible, async (newValue) => {
    if (newValue && address1.value) {
        // Várj a DOM frissítésére
        await nextTick();

        // Térkép inicializálása
        const map = L.map('map').setView([47.5079169, 19.0795471], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const pontok = [
            [47.5079169, 19.0795471],
            [47.4919, 19.0502],
            [47.4919, 19.0795471],
        ];
        const vonal = L.polyline(pontok, {color: 'blue'}).addTo(map);

        // Frissítsd a térkép méretét
        map.invalidateSize();
    }
});

onClickOutside(target, close)

// getGeoLocation('PETŐFI TÉR 4-6., GÖDÖLLŐ')
// getGeoLocation('HUNYADI U.  DEBRECEN ')
// getGeoLocation('PETŐFI. UTCA, TOLCSVA')

</script>

<template>
    <button @click="mapVisible = true"
            class="w-8 h-8 flex justify-center items-center bg-blue-50 rounded text-blue-900">
        <i class="fa-solid fa-map"></i>
    </button>
    <transition name="fade">
        <div v-if="mapVisible"
             class="fixed top-0 left-0 bg-gray-900 w-full h-screen z-40 flex justify-center items-center bg-opacity-25 backdrop-blur p-3">
            <div ref="target" id="map" class="border border-gray-900 w-full xl:w-[1200px] h-[800px]"></div>
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
