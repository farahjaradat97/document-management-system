<script setup>
defineProps({
    value: String,
    error:String
});
</script>

<template>
    <label 
    :class="error ? 'text-error' :''"
    class="block font-medium text-sm text-dark-gray-700 ">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
