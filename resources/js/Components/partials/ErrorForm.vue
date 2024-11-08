<script setup>

import InputLabel from "@/Components/form/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/form/TextInput.vue";
import {watchEffect, ref, onMounted} from 'vue';
import {isDutyTime} from "@/utils.js";



const props = defineProps({
    selectedEquipment: Object,
    orders: Object
});

const workerAvailable = ref(true)
const currentDuty = ref(null)
const locStorage = ref(null)

const form = useForm({
    equipment_id: props.selectedEquipment.id,
    contract_ref: props.selectedEquipment.contract_ref,
    name: props.selectedEquipment.name,
    address: props.selectedEquipment.address,
    type: props.selectedEquipment.type,
    equipment: props.selectedEquipment.equipment,
    emi: props.selectedEquipment.emi,
    worker: props.selectedEquipment.worker,
    description: '',
    error_type: 'normal',
    troubleshooter: 'kiadandó',
    isStand: 'igen',
    injured: 'n',
    whistleblower: '',
    whistleblower_tel: '',
    comment: '',
})


const storageKey = `equipment-${props.selectedEquipment.id}`;

if (localStorage.getItem(storageKey)) {

    locStorage.value = JSON.parse(localStorage.getItem(storageKey))

    form.description = locStorage.value.description;
    form.error_type = locStorage.value.error_type;
    form.troubleshooter = locStorage.value.troubleshooter;
    form.isStand = locStorage.value.isStand;
    form.injured = locStorage.value.injured;
    form.whistleblower = locStorage.value.whistleblower;
    form.whistleblower_tel = locStorage.value.whistleblower_tel;
    form.comment = locStorage.value.comment;
}


const stopWatch = watchEffect(() => {
    localStorage.setItem(storageKey, JSON.stringify(form));
});

// Tisztítsuk meg a Local Storage-t, ha az űrlapot elküldték
const submitForm = () => {
    stopWatch();
    localStorage.removeItem(storageKey);
    form.post(route('error.store'));
}

const selectWorker = (workerName) => {
    form.troubleshooter = workerName
}

onMounted(() => {
    const notAvailable = props.orders.filter(order => order.status === 'Szabadságon' || order.status === 'Külön munka')

    if (isDutyTime()) {
        workerAvailable.value = false
    }

    notAvailable.forEach(order => {
        if (order.worker.name === props.selectedEquipment.worker) {
            workerAvailable.value = false
        }
    })


    const elevatorDuty = props.orders.filter(order =>
        order.status.toLowerCase().includes('ügyeletes') &&
        !order.status.toLowerCase().includes('mozgólépcső')
    );

    const escalatorDuty = props.orders.filter(order => order.status === 'Mozgólépcső ügyeletes')


    if (props.selectedEquipment.type === 'Elevator') {
        currentDuty.value = elevatorDuty
    }

    if (props.selectedEquipment.type === 'Escalator') {
        currentDuty.value = escalatorDuty
    }


})
</script>

<template>
    <div class="bg-white p-6 rounded-2xl max-w-4xl">
        <form class="flex flex-col gap-3" @submit.prevent="submitForm">
            <div v-if="props.selectedEquipment.comment" class="p-3 bg-blue-100 rounded-2xl">
                <p class="text-blue-950">
                    <i class="fa-solid fa-circle-info mr-1.5"></i>
                    {{ props.selectedEquipment.comment }}
                </p>
            </div>
            <div class="flex gap-3">
                <span class="font-semibold text-gray-900"><span
                    class="text-gray-500">partner neve: </span>{{ props.selectedEquipment.name }}</span>
                <span v-if="props.selectedEquipment.emi" class="font-semibold text-gray-900"><span
                    class="text-gray-500">emi: </span>{{ props.selectedEquipment.emi }}</span>
                <span v-if="props.selectedEquipment.equipment" class="font-semibold text-gray-900"><span
                    class="text-gray-500">equipment: </span>{{ props.selectedEquipment.equipment }}</span>
            </div>
            <span class="font-semibold text-gray-900"><span
                class="text-gray-500">belépési cím: </span>{{ props.selectedEquipment.address }}</span>
            <div class="flex gap-3">

                    <span @click="selectWorker(props.selectedEquipment.worker)" class="font-semibold text-gray-900 hover:text-gray-600 cursor-pointer">
                        <span class="text-gray-500">karbantartó: </span>{{ props.selectedEquipment.worker }}
                    </span>

                <span v-if="!workerAvailable" class="text-red-500">
                        <i class="fa-solid fa-circle-exclamation mr-1.5 "></i>Nem elérhető
                    </span>

                <span v-if="!workerAvailable" class="font-semibold text-gray-900"><span class="text-gray-500">ügyeletes(ek): </span>
                        <span v-for="duty in currentDuty"
                              class="py-1 px-2 border  bg-green-100 rounded-2xl cursor-pointer hover:bg-green-200 mr-1.5"
                              @click="selectWorker(duty.worker.name)">
                            {{ duty.worker.name }}
                        </span>
                    </span>
            </div>

            <div class="flex flex-col gap-3">
                <div>
                    <input-label value="Hiba elhárító karbantartó"></input-label>
                    <text-input v-model="form.troubleshooter"></text-input>
                </div>
                <div class="w-full">
                    <input-label value="Hiba leírása"></input-label>
                    <textarea v-model="form.description"
                              class="border-gray-300 w-full dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    ></textarea>

<!--                    <AutoComplateText></AutoComplateText>-->
                </div>
            </div>
            <div class="flex gap-3">
                <div>
                    <input-label value="Hiba típusa"></input-label>
                    <input type="radio" id="normal" name="error_type" class="mr-1.5" checked value="normal"
                           v-model="form.error_type">
                    <label for="normal">normal</label><br>
                    <input type="radio" id="beragadas" name="error_type" class="mr-1.5" value="beragadas"
                           v-model="form.error_type">
                    <label for="beragadas">beragadás</label><br>
                    <input type="radio" id="feladat" name="error_type" class="mr-1.5" value="feladat"
                           v-model="form.error_type">
                    <label for="feladat">feladat</label><br>
                </div>
                <div>
                    <input-label value="Áll-e a lift?"></input-label>
                    <input type="radio" id="igen" name="stand" checked class="mr-1.5" value="igen"
                           v-model="form.isStand">
                    <label for="igen">igen</label><br>
                    <input type="radio" id="nem" name="stand" class="mr-1.5" value="nem" v-model="form.isStand">
                    <label for="nem">nem</label><br>
                </div>
                <div>
                    <input-label value="Hány sérült van?"></input-label>
                    <text-input v-model="form.injured"></text-input>
                </div>
                <div>
<!--                    <input-label value="Bejelentő neve"></input-label>-->
<!--                    <text-input v-model="form.whistleblower"></text-input>-->
                </div>
                <div>
<!--                    <AutoComplateInput v-model="form.whistleblower"></AutoComplateInput>-->
<!--                   <PrimeComponent v-model="form.whistleblower" route="getWhistleblower"></PrimeComponent>-->

                    <input-label value="Bejelentő"></input-label>
                    <text-input v-model="form.whistleblower"></text-input>
                </div>
                <div>
                    <input-label value="Bejelentő telefonszáma"></input-label>
                    <text-input v-model="form.whistleblower_tel"></text-input>
                </div>
            </div>

            <div class="w-full">
                <input-label value="Megjegyzés"></input-label>
                <textarea v-model="form.comment"
                          class="border-gray-300 w-full dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                ></textarea>
            </div>

            <div class="flex justify-end">
                <button
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                    type="submit"
                >Rögzít
                </button>
            </div>


        </form>
    </div>
</template>

<style scoped>

</style>
