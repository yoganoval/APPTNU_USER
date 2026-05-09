<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// Sesuaikan dengan field pada model:
// protected $fillable = ['title', 'description', 'date']
const form = useForm({
    title: '',
    description: '',
    date: '',
})

const submit = () => {
    // Sesuaikan dengan nama route yang menggunakan prefix admin
    form.post(route('admin.events.store'))
}
</script>

<template>
    <Head title="Create Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Tambah Event
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-3xl mx-auto px-4">
                <form
                    @submit.prevent="submit"
                    class="bg-white dark:bg-gray-800 rounded shadow p-6 space-y-4"
                >
                    <!-- Judul Event -->
                    <div>
                        <label class="block mb-1 font-medium">
                            Judul Event
                        </label>

                        <input
                            v-model="form.title"
                            type="text"
                            class="w-full border rounded p-2"
                        />

                        <div
                            v-if="form.errors.title"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.title }}
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block mb-1 font-medium">
                            Deskripsi
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="4"
                            class="w-full border rounded p-2"
                        ></textarea>

                        <div
                            v-if="form.errors.description"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block mb-1 font-medium">
                            Tanggal
                        </label>

                        <input
                            v-model="form.date"
                            type="date"
                            class="w-full border rounded p-2"
                        />

                        <div
                            v-if="form.errors.date"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.date }}
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>