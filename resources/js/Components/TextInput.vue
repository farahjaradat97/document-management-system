<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: String,
    message: String,
    hint: String,
});

const emit = defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
const clearInput = () => {
    emit("update:modelValue", "");
};
const isFocused = ref(false);
</script>

<template>
    <div class="relative">
        <input
            v-bind="$attrs"
            ref="input"
            :class="message? 'border-error' : ''"
            class="border-light-gray-300 shadow-input-shadow bg-white rounded-lg focus:border-primary focus:bg-white"
            :value="modelValue"
            @focus="isFocused = true"
            @input="$emit('update:modelValue', $event.target.value)"
        />
      
        <!-- <button
            v-if="modelValue && isFocused"
            type="button"
            @click="clearInput"
            class="absolute inset-y-0 right-0 flex items-center pr-3"
            aria-label="Clear input"
        >
            <i class="mdi mdi-close"> </i>
        </button> -->
    </div>
    <p class="font-small text-error text-sm mt-2" v-if="message">
        {{ message }}
    </p>
    <p class="font-small text-light-gray-500 text-sm" v-if="hint">
        {{ hint }}
    </p>
</template>
