<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    orderId: String
});

const form = useForm({})

const submitForm = () => {
    if (confirm('Biztosan törölni szeretnéd?')) {
        form.delete(route('order.destroy', {order: props.orderId}))
    }
}

</script>

<template>
    <form @submit.prevent="submitForm">
        <button type="submit" class="text-red-500"><i class="fa-solid fa-trash"></i></button>
    </form>

</template>

<style scoped>

</style>
