<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    certificates: Array
})
</script>

<template>
    <Head title="Certificates" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Certificates
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4">

                <div class="bg-white dark:bg-gray-800 rounded shadow overflow-hidden">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-100 dark:bg-gray-700">

                            <tr>
                                <th class="p-3 text-left">
                                    Peserta
                                </th>

                                <th class="p-3 text-left">
                                    Event
                                </th>

                                <th class="p-3 text-left">
                                    Template
                                </th>

                                <th class="p-3 text-left">
                                    Action
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr
                                v-for="certificate in certificates"
                                :key="certificate.id"
                                class="border-t dark:border-gray-700"
                            >

                                <td class="p-3">
                                    {{ certificate.user?.name }}
                                </td>

                                <td class="p-3">
                                    {{ certificate.event?.name }}
                                </td>

                                <td class="p-3">
                                    {{ certificate.template?.name }}
                                </td>

                                <td class="p-3 flex gap-2">

                                    <!-- VIEW -->
                                    <Link
                                        :href="route(
                                            'certificates.show',
                                            certificate.id
                                        )"

                                        class="px-3 py-1 rounded bg-blue-500 text-white hover:bg-blue-600"
                                    >
                                        View
                                    </Link>

                                    <!-- DOWNLOAD -->
                                    <a
                                        :href="route(
                                            'certificates.download',
                                            certificate.id
                                        )"

                                        class="px-3 py-1 rounded bg-green-500 text-white hover:bg-green-600"
                                    >
                                        Download
                                    </a>

                                </td>

                            </tr>

                            <tr v-if="!certificates.length">

                                <td
                                    colspan="4"
                                    class="p-6 text-center text-gray-500"
                                >
                                    Belum ada sertifikat
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>