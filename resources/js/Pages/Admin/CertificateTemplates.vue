<script setup>
import { Link, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    templates: Array
})
</script>

<template>
    <Head title="Template Sertifikat" />

    <AuthenticatedLayout>

        <!-- HEADER -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Template Sertifikat
            </h2>
        </template>

        <!-- CONTENT -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <!-- ACTION -->
                <div class="flex justify-end mb-6">
                    <Link
                        :href="route('admin.certificate.templates.create')"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition"
                    >
                        + Tambah Template
                    </Link>
                </div>

                <!-- LIST -->
                <div v-if="templates.length" class="grid md:grid-cols-3 gap-4">

                    <div
                        v-for="t in templates"
                        :key="t.id"
                        class="bg-white dark:bg-gray-800 rounded shadow p-4 transition"
                    >
                        <!-- IMAGE -->
                        <img
                            v-if="t.background_image"
                            :src="`/storage/${t.background_image}`"
                            class="w-full h-40 object-cover rounded mb-3"
                        />

                        <!-- NAME -->
                        <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                            {{ t.name }}
                        </h2>

                        <!-- ACTION -->
                        <div class="flex justify-between mt-3">
                            <Link
                                :href="route('admin.certificate.editor', t.id)"
                                class="text-blue-500 hover:underline text-sm"
                            >
                                Edit
                            </Link>
                        </div>
                    </div>

                </div>

                <!-- EMPTY -->
                <div v-else class="text-center text-gray-500 dark:text-gray-400">
                    Belum ada template 😢
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>