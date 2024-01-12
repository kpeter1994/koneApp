<script setup>
import { ref, onMounted, nextTick } from 'vue';
import axios from "axios";

const open = ref(false);
const actualMessage = ref('');
const messages = ref([

]);

const addMessage = (message) => {
    const newMessage = {
        id: messages.value.length + 1,
        message: actualMessage.value,
        sender: 'user',
        time: new Date().toLocaleTimeString(), // Ez az aktuális időt adja hozzá, de módosíthatod szükség szerint
    };
    messages.value.push(newMessage);

    axios.post('/api/send-message', {
        message: actualMessage.value,
    }).then((response) => {
        messages.value.push({
            id: messages.value.length + 1,
            message: response.data[0].text,
            sender: 'bot',
            time: new Date().toLocaleTimeString(),
        });
        console.log(response);
        console.log(messages.value);
        scrollToBottom();
    })
        .catch((error) => {
            console.log(error);
        });

    actualMessage.value = '';
}

const scrollToBottom = () => {
    nextTick(() => {
        const chatContainer = document.getElementById('chat-container');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
}

onMounted(() => {
    scrollToBottom();
});

</script>

<template>
    <div class="fixed bottom-3 right-3">
        <div @click="open = true" class="rounded-full h-12 bg-orange-500 cursor-pointer shadow-2xl">
            <img class="w-full h-full" src="../../../img/panda.png" alt="Panda">
        </div>
        <Transition name="slide-up" appear>
            <div v-if="open" class="fixed bottom-3 w-[370px] right-3 shadow rounded-2xl overflow-hidden max-w-md bg-white max-h-[600px] shadow-2xl">
            <div class="p-4 bg-orange-500 text-white font-semibold flex justify-between">
                <button><i class="fa-solid fa-arrow-left-long"></i></button>
                <button @click="open = false">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </div>
            <div class="p-3">
                <div class="flex gap-1.5 items-center">
                    <img class="w-12 rounded-full" src="../../../img/panda.png" alt="Panda">
                    <span class="font-semibold">Pandabot</span>
                </div>
            </div>
            <div id="chat-container" class="p-3 custom-scrollbar overflow-auto h-[400px]">
                <p v-for="message in messages" class="bg-slate-100 p-3 rounded-2xl mb-3">{{message.message}}</p>
            </div>
            <div class="p-3">
                <div class="flex gap-3">
                    <input @keyup.enter="addMessage(actualMessage)" class="w-full rounded-2xl border-2 border-gray-300 p-2" v-model="actualMessage" type="text" placeholder="Type your message...">
                </div>
            </div>

        </div>
        </Transition>
    </div>

</template>

<style scoped>
.custom-scrollbar {
    overflow-y: auto;
}

/* Elrejti a görgetősávot a WebKit motorokkal rendelkező böngészőkben */
.custom-scrollbar::-webkit-scrollbar {
    display: none;
}

/* Elrejti a görgetősávot az összes böngészőben */
.custom-scrollbar {
    -ms-overflow-style: none;  /* IE és Edge számára */
    scrollbar-width: none;  /* Firefox számára */
}

.slide-up-enter-active, .slide-up-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}
.slide-up-enter, .slide-up-leave-to /* 2.6.0+ */ {
    opacity: 0;
    transform: translateY(20px);
}
</style>
