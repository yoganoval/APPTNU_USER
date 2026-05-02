<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({
    layout: (h, page) => h(AuthenticatedLayout, {}, {
        default: () => page,
        header: () => 'Role Management'
    })
})

const props = defineProps({
    roles: Array,
    permissions: Array
})

const editing = ref(false)

const form = useForm({
    id: null,
    name: '',
    permissions: []
})

const submit = () => {
    if (editing.value) {
        form.put(route('admin.roles.update', form.id), {
            onSuccess: resetForm
        })
    } else {
        form.post(route('admin.roles.store'), {
            onSuccess: resetForm
        })
    }
}

const editRole = (role) => {
    editing.value = true
    form.id = role.id
    form.name = role.name
    form.permissions = role.permissions.map(p => p.name)
}

const resetForm = () => {
    editing.value = false
    form.reset()
}

const deleteRole = (role) => {
    if (confirm('Hapus role?')) {
        form.delete(route('admin.roles.destroy', role.id))
    }
}
</script>

<template>
<div class="p-6 text-gray-800 dark:text-gray-100 transition">

    <div class="grid grid-cols-12 gap-6">

        <!-- FORM -->
        <div class="col-span-4">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow sticky top-6 transition">

                <h2 class="text-lg font-semibold mb-4">
                    {{ editing ? 'Edit Role' : 'Create Role' }}
                </h2>

                <input
                    v-model="form.name"
                    placeholder="Role name"
                    class="border border-gray-300 dark:border-gray-700
                           bg-white dark:bg-gray-900
                           text-gray-800 dark:text-gray-100
                           w-full p-2 mb-4 rounded
                           focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                />

                <!-- PERMISSIONS -->
                <div class="h-64 overflow-y-auto border border-gray-300 dark:border-gray-700 rounded p-2">
                    <label
                        v-for="perm in permissions"
                        :key="perm.id"
                        class="flex items-center gap-2 text-sm py-1 text-gray-700 dark:text-gray-200"
                    >
                        <input
                            type="checkbox"
                            :value="perm.name"
                            v-model="form.permissions"
                            class="accent-blue-500"
                        />
                        {{ perm.name }}
                    </label>
                </div>

                <!-- BUTTON -->
                <div class="mt-4 flex gap-2">
                    <button
                        @click="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        {{ editing ? 'Update' : 'Save' }}
                    </button>

                    <button
                        v-if="editing"
                        @click="resetForm"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded transition"
                    >
                        Cancel
                    </button>
                </div>

            </div>
        </div>

        <!-- TABLE -->
        <div class="col-span-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden transition">

                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold">Role List</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-700 dark:text-gray-200">
                                <th class="p-3">Name</th>
                                <th class="p-3">Permissions</th>
                                <th class="p-3 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="role in roles"
                                :key="role.id"
                                class="border-t border-gray-200 dark:border-gray-700
                                       hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                            >
                                <td class="p-3 font-medium">
                                    {{ role.name }}
                                </td>

                                <td class="p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span
                                            v-for="p in role.permissions"
                                            :key="p.id"
                                            class="bg-gray-200 dark:bg-gray-700
                                                   text-gray-800 dark:text-gray-200
                                                   px-2 py-1 rounded text-xs"
                                        >
                                            {{ p.name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="p-3 text-center space-x-2">
                                    <button
                                        @click="editRole(role)"
                                        class="text-blue-600 dark:text-blue-400 hover:underline"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        @click="deleteRole(role)"
                                        class="text-red-600 dark:text-red-400 hover:underline"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="roles.length === 0">
                                <td colspan="3" class="text-center p-6 text-gray-500 dark:text-gray-400">
                                    Tidak ada role
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

</div>
</template>