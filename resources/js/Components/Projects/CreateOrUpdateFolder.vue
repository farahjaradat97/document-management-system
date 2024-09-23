<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "../InputLabel.vue";
import TextInput from "../TextInput.vue";
import PrimaryButton from "../PrimaryButton.vue";
import { onMounted, watch } from "vue";

//varaibles
const props = defineProps({
    folder: Object,
    projectId: String,
    parentFolder:Object
});
const form = useForm({
    name: props.folder?.name ?? "",
    parent: null,    id: null,
});
const emit = defineEmits(["showToaster", "close"]);

//Functions

// Function to create new folder or update exists folder
const createOrUpdateFolder = () => {
    form.parent = props.parentFolder.id;
    if (props.folder) {

    form.patch(route("projects.updateFolder", props.projectId), {
        onSuccess: () => {
                
                form.reset();
                emit('close')
                emit("showToaster", "Folder updated successfully!");
            },
        onFinish: () => form.reset(),
    });
    } else {
        form.post(route("projects.createFolder", props.projectId), {
            onSuccess: () => {
                form.reset();
                emit("showToaster", "Folder created successfully!");
                emit('close')
            },
        onFinish: () => form.reset(),
    });
    }
};
watch(
    () => props.folder,
    (newValue) => {
        if (props.folder) {
            form.name = props.folder.name;
            form.id=props.folder.id
        } else {
            form.name = "";
            form.id=null

        }
    }
);
</script>
<template>
    <form @submit.prevent="createOrUpdateFolder">
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
