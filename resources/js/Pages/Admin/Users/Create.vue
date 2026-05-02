<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({
    layout: (h, page) => h(AuthenticatedLayout, {}, {
        default: () => page,
        header: () => 'Tambah User'
    })
})

const props = defineProps({
    roles: Array
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: ''
})

const submit = () => {
    form.post('/admin/users')
}
</script>

<template>
<div class="p-6 max-w-xl text-gray-800 dark:text-gray-100 transition">

    <h1 class="text-xl font-bold mb-4">Tambah User</h1>

    <form @submit.prevent="submit" class="space-y-4">

        <!-- NAME -->
        <input
            v-model="form.name"
            placeholder="Nama"
            class="w-full border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-100
                   p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
        />

        <!-- EMAIL -->
        <input
            v-model="form.email"
            placeholder="Email"
            class="w-full border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-100
                   p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
        />

        <!-- PASSWORD -->
        <input
            type="password"
            v-model="form.password"
            placeholder="Password"
            class="w-full border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-100
                   p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
        />

        <!-- ROLE -->
        <select
            v-model="form.role"
            class="w-full border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-100
                   p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
        >
            <option value="">-- Pilih Role --</option>
            <option
                v-for="role in roles"
                :key="role.id"
                :value="role.name"
            >
                {{ role.name }}
            </option>
        </select>

        <!-- BUTTON -->
        <button
            class="bg-blue-500 hover:bg-blue-600
                   text-white px-4 py-2 rounded transition
                   disabled:opacity-50"
            :disabled="form.processing"
        >
            Simpan
        </button>

    </form>
</div>
</template>