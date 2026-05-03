<script setup>
import { Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({
    layout: (h, page) => h(AdminLayout, {}, {
        default: () => page,
        header: () => 'Template Sertifikat'
    })
})

defineProps({
    templates: Array
})
</script>

<template>
<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">
            Template Sertifikat
        </h1>

        <!-- 🔥 BUTTON TAMBAH -->
        <Link
            :href="route('admin.certificate.templates.create')"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
        >
            + Tambah Template
        </Link>
    </div>

    <!-- LIST TEMPLATE -->
    <div v-if="templates.length" class="grid md:grid-cols-3 gap-4">

        <div
            v-for="t in templates"
            :key="t.id"
            class="bg-white dark:bg-gray-800 rounded shadow p-4"
        >

            <!-- PREVIEW IMAGE -->
            <img
                v-if="t.background"
                :src="`/storage/${t.background}`"
                class="w-full h-40 object-cover rounded mb-3"
            />

            <!-- NAME -->
            <h2 class="font-semibold text-gray-800 dark:text-white">
                {{ t.name }}
            </h2>

            <!-- ACTION -->
            <div class="flex justify-between mt-3">

                <!-- EDIT -->
                <Link
                    :href="route('admin.certificate.editor', t.id)"
                    class="text-blue-500 hover:underline text-sm"
                >
                    Edit
                </Link>

                <!-- DELETE (optional nanti) -->
                <!-- <button class="text-red-500 text-sm">Hapus</button> -->

            </div>

        </div>

    </div>

    <!-- EMPTY STATE -->
    <div v-else class="text-center text-gray-500 dark:text-gray-400">
        Belum ada template 😢
    </div>

</div>
</template>