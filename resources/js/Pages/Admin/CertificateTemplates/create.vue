<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    background: null
})

const submit = () => {
    form.post(route('admin.certificate.templates.store'))
}
</script>

<template>
<div class="p-6 bg-white dark:bg-gray-800 rounded shadow">

    <h1 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
        Tambah Template
    </h1>

    <!-- NAME -->
    <input
        v-model="form.name"
        placeholder="Nama Template"
        class="border p-2 w-full mb-4 rounded
               bg-white dark:bg-gray-900
               text-gray-800 dark:text-white"
    />

    <!-- UPLOAD -->
    <input
        type="file"
        @change="e => form.background = e.target.files[0]"
        class="mb-4 text-gray-800 dark:text-white"
    />

    <!-- BUTTON -->
    <button
        @click="submit"
        class="bg-green-500 text-white px-4 py-2 rounded"
    >
        Simpan
    </button>

</div>
</template>