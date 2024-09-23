<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "../InputLabel.vue";
import TextInput from "../TextInput.vue";
import PrimaryButton from "../PrimaryButton.vue";
import { onMounted, watch } from "vue";

//varaibles
const props = defineProps({
    project: Object,
    orgId: Number,
});
const form = useForm({
    name: props.project?.name ?? "",
    org_id: props.orgId,
    id: null,
});
const emit = defineEmits(["showToaster", "close"]);

//Functions

// Function to create new project or update exists project
const createProject = () => {
    if (props.project) {
        form.patch(route("projects.update", props.project.id), {
            onSuccess: () => {
                
                form.reset();
                emit('close',true)
                emit("showToaster", "Project updated successfully!");
            },
            onFinish: () => form.reset(),
        });
    } else {
        form.post(route("projects.create"), {
            onSuccess: () => {
                form.reset();
                emit("showToaster", "Project created successfully!");
                emit('close',true)
            },
            onFinish: () => form.reset(),
        });
    }
};
watch(
    () => props.project,
    (newValue) => {
        if (props.project) {
            form.name = props.project.name;
            form.id = props.project.id;
        } else {
            form.name = "";
            form.id = null;
        }
    }
);
</script>
<template>
    <form @submit.prevent="createProject">
        <div class="p-4">
            <div>
                <InputLabel for="name" value="Name" :error="form.errors.name" />

                <TextInput id="name" type="text" class="w-full" v-model="form.name" required :message="form.errors.name"
                    autofocus />
            </div>
        </div>
        <div class="border-t border-light-gray-200 min-h-[55px] mt-3">
            <div class="p-4 py-3">
                <PrimaryButton type="submit"> Save</PrimaryButton>
            </div>
        </div>
    </form>
</template>
