<script setup>
import {ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";


const { flash } = usePage().props;
const flashMessage = ref(flash.success);


const form = useForm({
    excel_file: null
})

const handleFileUpload = (event) => {
    form.excel_file = event.target.files[0];
    console.log(form.excel_file);
};

const submit = () => {
   form.post(route('import'))
}


</script>

<template>
    <form @submit.prevent="submit">
        <label for="excel_file"><i class="fa-solid fa-file-excel"></i></label>
        <input id="excel_file" name="excel_file" type="file" @change="handleFileUpload" />

        <button type="submit">Importálás</button>
    </form>
    <div v-if="flashMessage">
        {{ flashMessage }}
    </div>
</template>

<style scoped>

</style>
