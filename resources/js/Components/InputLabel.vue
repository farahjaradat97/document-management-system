<script setup>
defineProps({
    value: String,
    error:String
});
</script>

<template>
    <label 
    :class="error ? 'text-rose-600' :''"
    class="block font-medium text-sm text-dark-gray-700 mb-2">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
