<script setup>
import {defineModel, ref, watch} from 'vue'
import InputLabel from "@/Components/form/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";

// const chargers = defineModel()

const props = defineProps({
    chargers: Object,
    message: String,
    issueNumber: String
})

const form = useForm({})

const search = ref('')

const emailCC = 'plugee@pandant.hu; info@molplugee.hu; LKohan@mol.hu; IsFile@MOL.hu; vlampert@mol.hu'

watch(search, value => {
    form.get(route('mol.index', {search: value}) , {
        preserveState: true,
        replace: true
    })
})



</script>

<template>
    <div class="p-6 bg-white rounded-2xl shadow w-full">
        <InputLabel label="Keresés" class="">Töltő</InputLabel>
        <input v-model="search" type="text" class="w-full border-gray-300 rounded-md">

        <div class="bg-slate-100 mt-4 p-3 rounded-2xl">
            <table>
                <tr>
                    <th class="px-2 py-1">ID</th>
                    <th class="px-2 py-1">Name</th>
                    <th class="px-2 py-1">Address</th>
                    <th class="px-2 py-1">Address</th>
                    <th class="px-2 py-1">Szervíz</th>
                    <th class="px-2 py-1">Újraindítási kód</th>
                    <th class="px-2 py-1">Újraindítási kód</th>

                </tr>
                <tr v-for="charger in props.chargers">
                    <td class="px-2 py-1">{{charger.charger_id}}</td>
                    <td class="px-2 py-1">{{charger.name}}</td>
                    <td class="px-2 py-1">{{charger.site_name}}</td>
                    <td class="px-2 py-1">{{charger.address}}</td>
                    <td class="px-2 py-1 capitalize">{{ charger.mol_service ? charger.mol_service.name : 'N/A' }}</td>
                    <td class="px-2 py-1">{{charger.router_password}}</td>
                    <td class="px-2 py-1">
                        <a class="text-blue-500 hover:text-blue-400" :href="`mailto:${charger.mol_service ? charger.mol_service.email : 'N/A'}
                        ?cc=${emailCC}
                       &subject=${charger.name} - Issue ${props.issueNumber}
                        &body=Tisztelt Partnerünk,%0D%0A%0D%0AA tárgyban szereplő töltőn az alábbi hiba tapasztalható:%0D%0A%0D%0A${props.message}.
                        %0D%0A%0D%0AKérjük a hiba kivizsgálását és elhárítását, illetve ha szükség van még további információra kérjük jelezzék.%0D%0AAmennyiben helyszíni kiszállás szükséges kérjük a megoldás után csatolják a válasz e-mailben a helyszíni jegyzőkönyvet is.
                        %0D%0A%0D%0A Üdvözlettel,%0D%0A${$page.props.auth.user.name}`">Küldj e-mailt</a>
                    </td>
                </tr>
            </table>

        </div>
    </div>

</template>

<style scoped>

</style>
