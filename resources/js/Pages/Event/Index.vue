<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    events: Array
})
</script>

<template>
    <Head title="Events" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    Event Management
                </h2>

                <Link
                    :href="route('admin.events.create')"
                    class="bg-blue-500 text-white px-4 py-2 rounded"
                >
                    + Tambah Event
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-3 text-left">Judul Event</th>
                                <th class="p-3 text-left">Deskripsi</th>
                                <th class="p-3 text-left">Tanggal</th>
                                <th class="p-3 text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="event in events"
                                :key="event.id"
                                class="border-t dark:border-gray-700"
                            >
                                <td class="p-3">
                                    {{ event.title }}
                                </td>

                                <td class="p-3">
                                    {{ event.description }}
                                </td>

                                <td class="p-3">
                                    {{ event.date }}
                                </td>

                                <td class="p-3 flex gap-2">
                                    <Link
                                        :href="route('admin.events.edit', event.id)"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded"
                                    >
                                        Edit
                                    </Link>

                                    <Link
                                        :href="route('admin.events.attendance', event.id)"
                                        class="bg-indigo-500 text-white px-3 py-1 rounded"
                                    >
                                        Absensi
                                    </Link>

                                    <Link
                                        :href="route('admin.certificates.generate', event.id)"
                                        method="post"
                                        as="button"
                                        class="bg-green-500 text-white px-3 py-1 rounded"
                                    >
                                        Generate Sertifikat
                                    </Link>

                                    <Link
                                        :href="route('admin.events.destroy', event.id)"
                                        method="delete"
                                        as="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded"
                                    >
                                        Delete
                                    </Link>
                                </td>
                            </tr>

                            <!-- Jika tidak ada data -->
                            <tr v-if="events.length === 0">
                                <td
                                    colspan="4"
                                    class="p-4 text-center text-gray-500"
                                >
                                    Belum ada data event.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>