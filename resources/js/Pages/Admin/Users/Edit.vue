<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

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
    <Head title="Edit User" />

    <AuthenticatedLayout>

        <!-- HEADER -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Edit User
            </h2>
        </template>

        <!-- CONTENT -->
        <div class="py-12">
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">

                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

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
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>