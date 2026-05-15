<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const page = usePage()
const event = page.props.event

// Sesuaikan field dengan kolom di database:
// protected $fillable = ['title', 'description', 'date']
const form = useForm({
    title: event.title,
    description: event.description,
    date: event.date,
})

const submit = () => {
    // Sesuaikan dengan nama route yang menggunakan prefix admin
    form.put(route('admin.events.update', event.id))
}
</script>

<template>
    <Head title="Edit Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Edit Event
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
                            class="w-full border border-gray-300 dark:border-gray-600 rounded p-2
                                bg-white dark:bg-gray-700
                                text-gray-900 dark:text-white
                                focus:ring-2 focus:ring-blue-500"
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
                            class="w-full border border-gray-300 dark:border-gray-600 rounded p-2
                                bg-white dark:bg-gray-700
                                text-gray-900 dark:text-white
                                focus:ring-2 focus:ring-blue-500"
                        >
                        </textarea>

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
                            class="w-full border border-gray-300 dark:border-gray-600 rounded p-2
                                bg-white dark:bg-gray-700
                                text-gray-900 dark:text-white
                                focus:ring-2 focus:ring-blue-500"
                        />

                        <div
                            v-if="form.errors.date"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.date }}
                        </div>
                    </div>

                    <!-- Tombol Update -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
                    >
                        {{ form.processing ? 'Updating...' : 'Update' }}
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>