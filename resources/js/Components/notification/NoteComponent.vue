<script setup>

import axios from "axios";
import {onMounted, ref, onUnmounted } from "vue";

const audio = new Audio('../../../audio/notification.mp3')

const notifications = ref([])
const previousLastVisitCount = ref(0); // Új reaktív referencia az előző lastVisitCount tárolására


const fetchNotifications = () => {
    axios.get(route('lastVisited')).then(response => {
        const newLastVisitCount = response.data.lastVisitCount;
        console.log(newLastVisitCount);

        if (newLastVisitCount > previousLastVisitCount.value) {
            playSound();
        }

        // Frissítjük az értékeket
        notifications.value = response.data;
        previousLastVisitCount.value = newLastVisitCount;
    });
}

onMounted(() => {
    fetchNotifications();
    const interval = setInterval(fetchNotifications, 600); // 60000 ms = 1 perc

    onUnmounted(() => {
        clearInterval(interval); // Töröljük az intervallumot, ha a komponens eltűnik
    });
});


const playSound = () => {
    audio.play()
}
</script>

<template>
    <div class="relative">
        <i class="fa-solid fa-bell text-lg"></i>
        <span v-if="notifications.lastVisitCount > 0" class="absolute -top-1 -right-1 flex h-4 w-4 flex" >
             <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
             <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-xs font-bold text-white justify-center items-center">
                 <span>{{notifications.lastVisitCount}}</span>
             </span>
        </span>

    </div>

</template>

<style scoped>

</style>
