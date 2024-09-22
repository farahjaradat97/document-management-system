<script setup>
const props = defineProps({
    message: String,
});
</script>

<template>
    <div
        class="flex flex-col items-center justify-center w-full p-2 gap-2 rounded-lg"
    >
        <i class="mdi mdi-progress-close text-primary"> </i>
        <p class="font-bold text-lg text-dark-gray-900">
            {{ message }}
        </p>
    </div>
</template>
