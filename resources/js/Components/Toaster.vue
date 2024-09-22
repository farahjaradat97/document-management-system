<script setup>

import { onMounted,ref } from 'vue';
const props = defineProps({
    message: {
        type: String,
        required: true,
    },
    type: {
        type: String,
    },
    duration: {
        reuired: false,
        default: 5000,
    },
});
const visible = ref(false);

onMounted(() => {
    visible.value = true;
    setTimeout(() => {
        visible.value = false;
    }, props.duration);
});
</script>
<template>
    <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div
            v-if="visible"
            class="fixed top-4 right-4 text-white text-center py-2 px-4 rounded-lg shadow-md w-[250px]"
            :class="{
                'bg-green-600': type === 'success',
                'bg-red-500': type === 'error',
            }"
        >
            {{ message }}
        </div>
    </transition>
</template>
