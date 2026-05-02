<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    users: Array
})
</script>

<template>
<div class="p-6">
    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">User Management</h1>
        <Link href="/admin/users/create" class="bg-blue-500 text-white px-4 py-2 rounded">
            + Tambah User
        </Link>
    </div>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2">Nama</th>
                <th class="p-2">Email</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id" class="border-t">
                <td class="p-2">{{ user.name }}</td>
                <td class="p-2">{{ user.email }}</td>
                <td class="p-2 space-x-2">
                    <Link :href="`/admin/users/${user.id}/edit`" class="text-yellow-500">
                        Edit
                    </Link>

                    <Link 
                        :href="`/admin/users/${user.id}`"
                        method="delete"
                        as="button"
                        class="text-red-500"
                    >
                        Hapus
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>