<script setup>

import {ref} from "vue";

const props = defineProps({
    flash: Object,
})

setTimeout(() => {
    showMessages.value = false;
}, 3000)

const showMessages = ref(true);
</script>

<template>
    <transition name="slide-up">
        <div v-if="props.flash.success && showMessages" class="absolute bg-white border border-l-4 border-green-500 p-6 gap-6 flex rounded items-center shadow-2xl z-40">
            <p><i class="fa-solid text-green-500 fa-circle-info mr-1.5"></i>{{props.flash.success}}</p>
            <i @click="showMessages = false" class="fa-solid fa-xmark cursor-pointer"></i>
        </div>
    </transition>

</template>

<style scoped>
.slide-up-enter-active, .slide-up-leave-active {
    transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
}
.slide-up-enter-from, .slide-up-leave-to {
    transform: translateY(-100%);
    opacity: 0;
}
.slide-up-enter-to, .slide-up-leave-from {
    transform: translateY(0);
    opacity: 1;
}
</style>
