<script setup>
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: ''
})

const submit = () => {
    form.post('/admin/users')
}
</script>

<template>
<div class="p-6 max-w-xl">
    <h1 class="text-xl font-bold mb-4">Tambah User</h1>

    <form @submit.prevent="submit" class="space-y-4">
        <input v-model="form.name" placeholder="Nama" class="w-full border p-2 rounded" />
        <input v-model="form.email" placeholder="Email" class="w-full border p-2 rounded" />
        <input type="password" v-model="form.password" placeholder="Password" class="w-full border p-2 rounded" />

        <button class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
</template>