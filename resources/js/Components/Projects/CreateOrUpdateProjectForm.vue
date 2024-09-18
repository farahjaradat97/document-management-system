<script setup>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '../InputLabel.vue';
import TextInput from '../TextInput.vue';
import PrimaryButton from '../PrimaryButton.vue';
import { onMounted,watch } from 'vue';

const props=defineProps({
    project:Object
})
const form =useForm({
name:props.project?.name ?? ''

})

</script>
<template>
    <form @submit.prevent="createProject">
        <div class="p-4">
            <div>
                <InputLabel for="name" value="name" :error="form.errors.name"/>
    
                <TextInput id="name" type="text" class="w-full" v-model="form.name" required
                    :message="form.errors.name" autofocus />
            </div>
        </div>
        <div class="border-t border-light-gray-200 min-h-[55px] mt-3">
            <div class="p-4 py-3">
                <PrimaryButton type="submit"> Save</PrimaryButton>
            </div>
        </div>
    </form>
</template>