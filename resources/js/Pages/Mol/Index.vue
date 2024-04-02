<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";
import {onClickOutside, } from "@vueuse/core";
import ToastComponent from "@/Components/notification/ToastComponent.vue";
import MolLogo from "@/Components/image/MolLogo.vue";
import ErrorCodeList from "@/Pages/Mol/components/ErrorCodeList.vue";
import ChargersComponent from "@/Pages/Mol/components/ChargersComponent.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";
import UpdateComponent from "@/Pages/Mol/components/UpdateComponent.vue";
import MessageComponent from "@/Pages/Mol/components/MessageComponent.vue";



const props = defineProps({
    user: Object,
    flash: Object,
    chargers: Object
})


const errorMessage = ref('')
const issue = ref('')


const createVisible = ref(false)
const target = ref(null)

const close = () => createVisible.value = false

onClickOutside(target, close)
</script>

<template>
    <Head title="MOL Plugge" />

    <AuthenticatedLayout>

        <template #toast>
            <ToastComponent :flash="props.flash"></ToastComponent>
        </template>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <MolLogo class="opacity-70 h-6 inline-flex" />
                MOL Plugge</h2>
        </template>

        <Transition name="slide-up" appear>
            <div class="py-6 px-3">
            <div class="max-w-7xl mx-auto flex justify-end">


            </div>

            <div class="">

                <div class="flex flex-wrap">

                    <div class="w-9/12">
                        <ChargersComponent class="mb-6" :issueNumber="issue" :message="errorMessage" :chargers="props.chargers"></ChargersComponent>

                        <ErrorCodeList></ErrorCodeList>
                    </div>
                    <div class="w-3/12 pl-3">
                        <div class="p-6 bg-white rounded-2xl shadow">
                            <InputLabel label="Keresés" class="">Hiba üzenet</InputLabel>
                            <textarea v-model="errorMessage" class="w-full h-36 border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="p-6 mt-3 bg-white rounded-2xl shadow">
                            <InputLabel label="Keresés" class="">Issue</InputLabel>
                            <text-input v-model="issue" class="w-full"></text-input>
                        </div>
                        <div class="p-6 mt-3 bg-white rounded-2xl shadow">
                            <MessageComponent></MessageComponent>
                        </div>

                        <div class="p-6 mt-3 bg-white rounded-2xl shadow">
                            <UpdateComponent></UpdateComponent>
                        </div>

                    </div>


                </div>


            </div>

        </div>
        </Transition>


    </AuthenticatedLayout>
</template>

<style>

</style>
