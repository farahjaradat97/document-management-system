<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import InputError from "../InputError.vue";
const props = defineProps({
  
    projectId: {
        type: String,
    },
    reset: {
        type: Boolean,
        default: false,
    },
    requiredError:{
      type:Boolean,
      default:false
    }
});
const errorMessage = ref(null);
const file = ref(null);
const isDragging = ref(false);
const loading = ref(false);

// Emits the 'update' event to the parent component
const emit = defineEmits(["update", "error", "loading"]);

// Handles file input selection
const handleFileInputClick = (event) => {
    document.getElementById("file-input").click();
    loading.value = false;
};

// Handles file upload process
const handleFileUpload = async (event, isDrag) => {
    errorMessage.value = null;
    loading.value = true;
    emit("error", false);
    emit("loading", true);

    // Get the file from the input
    if (isDrag) {
        file.value = event;
    } else {
        file.value = event.target.files[0];
    }
  
    if (file.value && file.value.type !== "application/pdf") {
        errorMessage.value = "Only PDF files are allowed.";
        loading.value = false;
        emit("error", true);
        emit("loading", false);
        return;
    }
    if (file.value) {
        const formData = new FormData();
        formData.append("file", file.value);
        try {
            const response = await axios.post(
                route("projects.uploadFile", props.projectId),
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            file.value = response.data.file;
            emit("update", file.value);
        } catch (e) {
            console.error("File upload failed", e);
        } finally {
            emit("loading", false);
            loading.value = false;
        }
    }
};

// Handle drag events
const onDragOver = (event) => {
    event.preventDefault();
    isDragging.value = true;
};

const onDragLeave = () => {
    isDragging.value = false;
};

// Handle file drop event
const onDrop = (event) => {
    event.preventDefault();
    isDragging.value = false;
    // Get the dropped file

    file.value = event.dataTransfer.files[0];
    handleFileUpload(file.value, true);
};
watch(
    () => props.reset,
    (newValue) => {
        if (newValue && file.value) {
            file.value = null;
        }
    }
);
watch(
    () => props.requiredError,
    (newValue) => {
        if (newValue ==true) {
            errorMessage.value = 'Please Select File';
        }
        else{
          errorMessage.value = null;

          
        }
    }
);
</script>

<template>
    <div class="flex flex-col items-center">
        <div
            class="w-full border-2 border-dashed border-light-gray-300 rounded-lg p-6 text-center cursor-pointer transition-colors"
            :class="[
                { 'border-blue-500 bg-blue-50': isDragging },
                { 'border-red-600': errorMessage },
            ]"
            @dragover="onDragOver"
            @dragleave="onDragLeave"
            @drop="onDrop"
            @click="handleFileInputClick"
        >
            <input
                id="file-input"
                v-if="!loading"
                type="file"
                @change="handleFileUpload"
                accept="application/pdf"
                class="hidden"
            />

            <div v-if="!file && !loading">
                <p class="text-sm text-gray-500">
                    Drag and drop a file here, or click to select one
                </p>
            </div>

            <div
                v-if="loading"
                class="flex justify-center items-center space-x-2"
            >
                <svg
                    class="animate-spin h-5 w-5 text-gray-600"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                    ></path>
                </svg>
                <span class="ml-2 text-gray-600">Uploading...</span>
            </div>

            <div v-if="file && !loading" class="mt-4">
                <div
                    class="border p-2 rounded-lg flex items-center justify-between w-full"
                >
                    <p class="truncate w-full">{{ file.name }}</p>
                    <button
                        @click.stop="
                            {
                                file = null;
                                loading = false;
                            }
                        "
                        class="ml-2 text-red-500 hover:text-red-700"
                    >
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-1">
        <InputError :message="errorMessage"></InputError>
    </div>
</template>

<style scoped>
.dragging {
    border-color: #3b82f6;
    background-color: #eff6ff;
}
</style>
