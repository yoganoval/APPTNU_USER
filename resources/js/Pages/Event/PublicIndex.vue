<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    events: Array
})

const cardClass =
    'bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-200 dark:border-gray-700'
</script>

<template>
    <Head title="Daftar Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Daftar Event
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="event in events"
                        :key="event.id"
                        :class="cardClass"
                    >
                        <!-- Judul -->
                        <h3
                            class="text-lg font-bold text-gray-900 dark:text-white mb-2"
                        >
                            {{ event.title }}
                        </h3>

                        <!-- Deskripsi -->
                        <p
                            class="text-gray-600 dark:text-gray-300 mb-3"
                        >
                            {{ event.description || 'Tidak ada deskripsi.' }}
                        </p>

                        <!-- Tanggal -->
                        <p
                            class="text-sm text-gray-500 dark:text-gray-400 mb-4"
                        >
                            Tanggal: {{ event.date }}
                        </p>

                        <!-- 1. Event sudah lewat -->
                        <div
                            v-if="!event.is_registration_open"
                            class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 px-3 py-2 rounded text-center font-semibold"
                        >
                            Pendaftaran Ditutup
                        </div>

                        <!-- 2. Sudah hadir -->
                        <div
                            v-else-if="event.attended"
                            class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-3 py-2 rounded text-center font-semibold"
                        >
                            Hadir ✓
                        </div>

                        <!-- 3. Sudah terdaftar -->
                        <div
                            v-else-if="event.is_registered"
                            class="bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 px-3 py-2 rounded text-center font-semibold"
                        >
                            Sudah Terdaftar
                        </div>

                        <!-- 4. Belum terdaftar -->
                        <Link
                            v-else
                            :href="route('admin.events.register', event.id)"
                            method="post"
                            as="button"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold"
                        >
                            Daftar Event
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>