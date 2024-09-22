<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
props.active
        ? 'inline-flex bg-transparent items-center h-16 p-0 text-sm font-medium leading-5 text-dark-gray-900 focus:outline-none transition duration-150 ease-in-out border-b-2 border-primary'
        : 'inline-flex items-center text-sm font-medium h-16 leading-5 text-dark-gray-900 focus:outline-none focus:text-dark-gray-700 transition duration-150 ease-in-out p-2 hover:bg-light-gray-200'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
