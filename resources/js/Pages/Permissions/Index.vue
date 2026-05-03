<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
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

// CRUD
const actions = ['view', 'create', 'edit', 'delete']

const form = useForm({
    module: '',
    actions: [],
    custom: ''
})

const toggleAction = (value) => {
    if (form.actions.includes(value)) {
        form.actions = form.actions.filter(a => a !== value)
    } else {
        form.actions.push(value)
    }
}

// parse custom
const customList = computed(() => {
    return form.custom
        ? form.custom.split(',').map(p => p.trim()).filter(p => p)
        : []
})

// preview gabungan
const previewPermissions = computed(() => {
    let result = []

    if (form.module) {
        result = form.actions.map(a => `${form.module}.${a}`)
    }

    return [...result, ...customList.value]
})

const submit = () => {
    if (!previewPermissions.value.length) {
        alert('Isi data dulu')
        return
    }

    form.post(route('admin.permissions.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset()
    })
}
</script>

<template>
<div class="bg-white dark:bg-gray-800 p-6 rounded shadow transition">

    <!-- MODULE -->
    <input
        v-model="form.module"
        placeholder="Module (contoh: certificate)"
        class="border border-gray-300 dark:border-gray-700
               bg-white dark:bg-gray-900
               text-gray-800 dark:text-gray-100
               p-2 w-full mb-4 rounded
               placeholder-gray-400 dark:placeholder-gray-500"
    />

    <!-- CRUD -->
    <div class="flex gap-4 mb-4 flex-wrap text-gray-800 dark:text-gray-200">
        <label
            v-for="a in actions"
            :key="a"
            class="flex items-center gap-2 cursor-pointer"
        >
            <input
                type="checkbox"
                :checked="form.actions.includes(a)"
                @change="toggleAction(a)"
                class="accent-blue-500"
            />
            {{ a }}
        </label>
    </div>

    <!-- CUSTOM -->
    <input
        v-model="form.custom"
        placeholder="Custom: certificate.pdf, laporan.print"
        class="border border-gray-300 dark:border-gray-700
               bg-white dark:bg-gray-900
               text-gray-800 dark:text-gray-100
               p-2 w-full mb-4 rounded
               placeholder-gray-400 dark:placeholder-gray-500"
    />

    <!-- PREVIEW -->
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        <p>Preview:</p>

        <div class="flex flex-wrap gap-2 mt-2">
            <span
                v-for="p in previewPermissions"
                :key="p"
                class="px-2 py-1 text-xs rounded
                       bg-blue-100 text-blue-700
                       dark:bg-blue-700 dark:text-white"
            >
                {{ p }}
            </span>
        </div>
    </div>

    <!-- BUTTON -->
    <button
        @click="submit"
        class="bg-green-500 hover:bg-green-600
               text-white px-4 py-2 rounded
               transition"
    >
        Simpan Permission
    </button>

    <!-- LIST -->
    <div class="mt-6 flex flex-wrap gap-2">
        <span
            v-for="p in permissions"
            :key="p.id"
            class="px-2 py-1 text-xs rounded
                   bg-gray-100 text-gray-700
                   dark:bg-gray-700 dark:text-gray-200"
        >
            {{ p.name }}
        </span>
    </div>

</div>
</template>