<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>
<template>
  <Head title="Projects" />

  <AuthenticatedLayout
  title="Projects"
  >
    <template #action>
      <PrimaryButton>New project</PrimaryButton>
    </template>
  </AuthenticatedLayout>
</template>
