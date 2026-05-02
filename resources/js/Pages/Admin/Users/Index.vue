<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({
    layout: (h, page) => h(AuthenticatedLayout, {}, {
        default: () => page,
        header: () => 'User Management'
    })
})

defineProps({
    users: Array
})
</script>

<template>
<div class="p-6 text-gray-800 dark:text-gray-100 transition">

    <!-- HEADER ACTION -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">User Management</h1>

        <Link
            href="/admin/users/create"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
        >
            + Tambah User
        </Link>
    </div>

    <!-- TABLE -->
    <div class="bg-white dark:bg-gray-800 shadow rounded overflow-hidden transition">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-700 dark:text-gray-200">
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="user in users"
                    :key="user.id"
                    class="border-t border-gray-200 dark:border-gray-700
                           hover:bg-gray-50 dark:hover:bg-gray-700/50
                           transition"
                >
                    <td class="p-3">{{ user.name }}</td>
                    <td class="p-3">{{ user.email }}</td>

                    <!-- ROLE -->
                    <td class="p-3">
                        <span
                            v-for="role in user.roles"
                            :key="role.id"
                            class="bg-gray-200 dark:bg-gray-700
                                   text-gray-800 dark:text-gray-200
                                   px-2 py-1 rounded text-xs mr-1"
                        >
                            {{ role.name }}
                        </span>

                        <span v-if="!user.roles || user.roles.length === 0"
                            class="text-gray-400 dark:text-gray-500 text-sm">
                            -
                        </span>
                    </td>

                    <!-- ACTION -->
                    <td class="p-3 text-center space-x-2">

                        <Link
                            :href="`/admin/users/${user.id}/edit`"
                            class="text-yellow-500 hover:text-yellow-600 dark:hover:text-yellow-400 transition"
                        >
                            Edit
                        </Link>

                        <Link
                            :href="`/admin/users/${user.id}`"
                            method="delete"
                            as="button"
                            class="text-red-500 hover:text-red-600 dark:hover:text-red-400 transition"
                            onclick="return confirm('Yakin hapus user?')"
                        >
                            Hapus
                        </Link>

                    </td>
                </tr>

                <!-- EMPTY -->
                <tr v-if="users.length === 0">
                    <td colspan="4" class="text-center p-6 text-gray-500 dark:text-gray-400">
                        Tidak ada user
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
</template>