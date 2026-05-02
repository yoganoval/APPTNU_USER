<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({
    layout: (h, page) => h(AdminLayout, {}, {
        default: () => page,
        header: () => 'Permission Management'
    })
})

defineProps({
    permissions: Array
})

const form = useForm({
    name: ''
})

const submit = () => {
    form.post(route('admin.permissions.store'), {
        onSuccess: () => form.reset()
    })
}
</script>

<template>
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow transition text-gray-800 dark:text-gray-100">

        <!-- INPUT -->
        <input
            v-model="form.name"
            placeholder="permission.name"
            class="border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-900
                   text-gray-800 dark:text-gray-100
                   p-2 w-full mb-2 rounded
                   focus:outline-none focus:ring-2 focus:ring-green-500 transition"
        />

        <!-- BUTTON -->
        <button
            @click="submit"
            class="bg-green-500 hover:bg-green-600
                   text-white px-4 py-2 rounded transition"
        >
            Add Permission
        </button>

        <!-- LIST -->
        <div class="flex flex-wrap gap-2 mt-4">
            <span
                v-for="p in permissions"
                :key="p.id"
                class="px-2 py-1 text-xs rounded
                       bg-gray-100 dark:bg-gray-700
                       text-gray-700 dark:text-gray-200"
            >
                {{ p.name }}
            </span>
        </div>

    </div>
</template>