<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({
    layout: (h, page) => h(AuthenticatedLayout, {}, {
        default: () => page,
        header: () => 'Edit User'
    })
})

const props = defineProps({
    user: Object,
    roles: Array
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.roles?.[0]?.name || ''
})

const submit = () => {
    form.put(`/admin/users/${props.user.id}`)
}
</script>

<template>
<div class="p-6 max-w-xl text-gray-800 dark:text-gray-100 transition">

    <h1 class="text-xl font-bold mb-4">Edit User</h1>

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
            class="bg-green-500 hover:bg-green-600
                   text-white px-4 py-2 rounded transition"
        >
            Update
        </button>

    </form>
</div>
</template>