<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const form = useForm({
    name: '',
    description: '',
    date: '',
    location: ''
})

const submit = () => {
    form.post(route('events.store'))
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

                    <div>
                        <label>Nama Event</label>

                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full border rounded p-2"
                        />
                    </div>

                    <div>
                        <label>Deskripsi</label>

                        <textarea
                            v-model="form.description"
                            class="w-full border rounded p-2"
                        ></textarea>
                    </div>

                    <div>
                        <label>Tanggal</label>

                        <input
                            v-model="form.date"
                            type="date"
                            class="w-full border rounded p-2"
                        />
                    </div>

                    <div>
                        <label>Lokasi</label>

                        <input
                            v-model="form.location"
                            type="text"
                            class="w-full border rounded p-2"
                        />
                    </div>

                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        Simpan
                    </button>

                </form>

            </div>
        </div>

    </AuthenticatedLayout>
</template>