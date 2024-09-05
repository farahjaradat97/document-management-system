<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    as: String,
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" type="submit" class="text-base block w-full px-4 py-2 text-start text-sm leading-5 text-dark-gray-900  hover:bg-light-gray-200  focus:outline-none focus:bg-light-gray  transition duration-150 ease-in-out">
            <slot />
        </button>

        <a v-else-if="as =='a'" :href="href" class="block text-base px-4 py-2 text-sm leading-5 text-dark-gray-900  hover:bg-light-gray focus:outline-none focus:bg-light-gray  transition duration-150 ease-in-out">
            <slot />
        </a>

        <Link v-else :href="href" class=" text-base block px-4 py-2 text-sm leading-5 text-dark-gray-900   hover:bg-light-gray  focus:outline-none focus:bg-light-gray  transition duration-150 ease-in-out">
            <slot />
        </Link>
    </div>
</template>
