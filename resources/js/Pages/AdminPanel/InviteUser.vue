<script setup>
import HeaderLayout from "@/Layouts/HeaderLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    orgId: String,
    breadcrumbs: Array
})
const form = useForm({
    email: '',
    role: ''
})
const submit = () => {
    form.post(route('organizations.inviteUser', props.orgId));
}
</script>
<template>
    <AuthenticatedLayout title="Invite User" :bread-crumbs="breadcrumbs">
        <template #content>

            <form @submit.prevent="submit" class="flex flex-col gap-6 w-full">
                <div class="w-full flex-col flex gap-6 bg-white border border-gray-200 mt-2 rounded-lg p-4">
<div >

    <InputLabel> Email</InputLabel>
    <TextInput id="email" type="email" class=" w-1/2" required v-model="form.email" autofocus
        autocomplete="username" />
</div>
<div>

    <InputLabel> Role</InputLabel>
    <div class="flex gap-2">
        <InputLabel>
            <input id="admin" type="radio" v-model="form.role" autofocus class="mr-2"
                value="Admin" />Admin
        </InputLabel>
        <InputLabel>
            <input id="user" type="radio" v-model="form.role" autofocus class="mr-2" value="User" />User
        </InputLabel>
</div>
                    </div>
                </div>
                <div class="flex gap-2">

                    <PrimaryButton class="mt-2" type="submit"> Invite</PrimaryButton>
                    <!-- <PrimaryButton class="mt-2" type="submit"> Invite & invite another</PrimaryButton> -->
                </div>
            </form>
        </template>
    </AuthenticatedLayout>

</template>
