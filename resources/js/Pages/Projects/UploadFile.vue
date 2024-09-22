<script setup>
import HeaderLayout from "@/Layouts/HeaderLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Link } from "@inertiajs/vue3";
import Toaster from "@/Components/Toaster.vue";
import { ref, computed, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UploaderInput from "@/Components/Projects/UploaderInput.vue";
const props = defineProps({
    folder: Object,
    breadcrumbs: Object,
    projectId: String,
    file: Object,
});
const hasTypeError = ref(false);
const requiredFileError = ref(false);
const isLoading = ref(false);
const resetFileUploader = ref(false);
const showToaster = ref(false);
const form = useForm({
    related_files:['OCC/C2201/ALF/MS/0013' , 
        'ALF/DMUD/MEP/016/R0'
    ],
    name: "",
    parent: null,
    reference_number: null,
    subject: "",
    date: "",
    path: "",
    mime: "",
    size: "",
    redirect: false,
});
const handleFileSelected = (event) => {
    (form.path = event.url),
        (form.size = event.size),
        (form.mime = event.mimeType);
};
const handelFileLoading = (event) => {
    isLoading.value = event;
};
const handelFileError = (event) => {
    hasTypeError.value = event;
};

const submit = (redirect) => {
    form.parent = props?.folder;
    form.redirect = redirect;
    showToaster.value = false;

    form.put(route("projects.updateFile", {id:props.projectId,fileId :props.file.id}), {
        onSuccess: () => {
            form.reset();
            resetFileUploader.value = true;
            showToaster.value = true;
        },
        onError: () => {
            if (form.errors.path) {
                requiredFileError.value = true;
            }
        },
    });
};

onMounted(() => {
    if (props.file) {
        const {
            name,
            subject,
            date,
            path,
            reference_number,
            parent,
            mime,
            size,
        } = props.file;
        form.name = name;
        form.subject = subject;
        form.reference_number = reference_number;
        form.date = date;
        form.path = path;
        form.parent = parent;
        form.size = size;
        form.mime = mime;
    }
});
</script>
<template>
    <AuthenticatedLayout title="Upload File" :bread-crumbs="breadcrumbs.data">
        <template #content>
            <Toaster message="File uploaded successfully" v-if="showToaster" type="success">
            </Toaster>
            <form @submit.prevent="submit(true)" class="flex flex-col gap-6 w-full">
                <div class="w-full flex-col flex gap-6 bg-white border border-gray-200 mt-2 rounded-lg p-4">
                    <div class="w-full flex flex-col sm:flex-row gap-8">
                        <div class="sm:w-1/2 w-full">
                            <InputLabel> Name</InputLabel>
                            <TextInput required id="name" type="text" class="w-full" :message="form.errors.name"
                                v-model="form.name" autofocus />
                        </div>
                        <div class="sm:w-1/2">
                            <InputLabel> Subject</InputLabel>
                            <TextInput required id="subject" type="text" class="w-full" :message="form.errors.subject"
                                v-model="form.subject" autofocus />
                        </div>
                    </div>

                    <div class="w-full flex flex-col sm:flex-row gap-8">
                        <div class="sm:w-1/2 w-full">
                            <InputLabel> Refrence Number</InputLabel>
                            <TextInput id="refrence_num" type="text" required class="w-full"
                                :message="form.errors.reference_number" v-model="form.reference_number" autofocus />
                        </div>
                        <div class="sm:w-1/2 w-full">
                            <InputLabel> Date</InputLabel>
                            <TextInput id="date" class="w-full" required type="date" :message="form.errors.date"
                                v-model="form.date" autofocus />
                        </div>
                    </div>

                    <div class="w-full flex flex-col sm:flex-row sm:pr-8">
                        <div class="sm:w-1/2 w-full">
                            <InputLabel for="name" value="File" class="" />

                            <UploaderInput :project-id="projectId" :reset="resetFileUploader"
                            :file="file"
                                :requiredError="requiredFileError" @update="handleFileSelected" @error="handelFileError"
                                @loading="handelFileLoading" />
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <PrimaryButton class="mt-2" type="submit" :disabled="isLoading">
                        Save</PrimaryButton>
                    <PrimaryButton :disabled="isLoading" class="mt-2" type="button" @click="submit(false)">
                        Save & uplode another</PrimaryButton>
                    <Link :href="route('projects.folder', {
                        id: projectId,
                        folders: folder.path,
                    })
                        ">
                    <PrimaryButton class="mt-2" type="button" outlined>Cancel</PrimaryButton>
                    </Link>
                </div>
            </form>
        </template>
    </AuthenticatedLayout>
</template>
