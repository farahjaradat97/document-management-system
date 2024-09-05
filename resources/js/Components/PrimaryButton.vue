<script setup>
defineProps({
    type: {
        type: String,
        default: "submit",
    },
    outlined: {
        type: Boolean,
        default: false,
        required: false
    },
    leftIcon: {
        type: String,
        required: false
    },
    rightIcon: {
        type: String,
        required: false
    },
    icon: {
        type: String,
        required: false
    }
});
</script>

<template>
    <button v-bind="$attrs"
        :class="[outlined ? 'bg-white border-light-gray-300 disabled:hover:bg-white text-dark-gray-800  hover:bg-light-gray-200' : 'bg-primary text-white hover:bg-light-primary disabled:hover:bg-primary ']"
        :type="type"
        class="flex justify-around gap-2  items-center shadow-btn-shadow rounded-lg items-center px-[6px] py-[12px] text-sm  font-medium capitlize  disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150 min-w-[70px] max-h-[36px]">
     
        <div>
            <i v-if="leftIcon" :class="`mdi ${leftIcon}`">

            </i>
            <slot />
            <i v-if="rightIcon" :class="`mdi ${rightIcon}`">

            </i>
        </div>

    </button>
</template>
