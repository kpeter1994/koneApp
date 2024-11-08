<script setup>
import axios from "axios";
import {defineEmits} from "vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    feed: Object
})

const emits = defineEmits(['feedUpdated'])

const form = useForm({
})

const markAsSolved = (id) => {
    confirm('Biztosan megoldottad a feladatot?')
   axios.patch(`/feed/${id}/solved`)
       .then(res => {
           console.log(res.data.feed)
           emits('feedUpdated', res.data.feed)
       })
}

</script>

<template>
    <div>
        <button @click="markAsSolved(props.feed.id)" class="absolute top-0 right-0 py-1 px-2 bg-blue-200 hover:bg-blue-100 rounded-full font-semibold text-sm">
            <i class="fa-solid fa-list-check mr-1"></i>
            Kezelve
        </button>
    </div>
</template>

<style scoped>

</style>
