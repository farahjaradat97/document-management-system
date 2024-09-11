<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head ,useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
const form = useForm({
    name: "",
});

const post=()=>{
  console.log('enter');
  
}
const openCreateProjectModal = ref(false);
</script>
<template>
    <Head title="Projects" />
    <AuthenticatedLayout title="Projects">
        <template #action>
            <PrimaryButton @click="openCreateProjectModal = true"
                >New project</PrimaryButton
            >
        </template>
    </AuthenticatedLayout>

    <Modal
    max-width="md"
        :show="openCreateProjectModal"
        @close="openCreateProjectModal = false"
        title="Create Project"
        @update="post"
    >
        <div>
            <InputLabel for="name" value="name" />

            <TextInput
                id="name"
                type="text"
                class="w-full"
                v-model="form.name"
                required
                :message="form.errors.name"
                autofocus

            />
           
        </div>
    </Modal>
</template>
