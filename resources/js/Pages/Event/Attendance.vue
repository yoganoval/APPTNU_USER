<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    event: Object,
    participants: Array,
})

const form = useForm({
    participants: props.participants
        .filter((participant) => participant.attended)
        .map((participant) => participant.id),
})

const inputClass =
    'rounded border-gray-300 dark:border-gray-600 ' +
    'bg-white dark:bg-gray-700 ' +
    'text-gray-900 dark:text-white'

const submit = () => {
    form.post(route('admin.events.attendance.update', props.event.id))
}
</script>

<template>
    <Head :title="`Absensi - ${event.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Absensi Event: {{ event.title }}
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-5xl mx-auto px-4">
                <form
                    @submit.prevent="submit"
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6"
                >
                    <p class="mb-6 text-gray-600 dark:text-gray-300">
                        Tanggal: {{ event.date }}
                    </p>

                    <div class="space-y-3">
                        <label
                            v-for="participant in participants"
                            :key="participant.id"
                            class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg"
                        >
                            <div>
                                <div
                                    class="font-semibold text-gray-900 dark:text-white"
                                >
                                    {{ participant.name }}
                                </div>
                                <div
                                    class="text-sm text-gray-500 dark:text-gray-400"
                                >
                                    {{ participant.email }}
                                </div>
                            </div>

                            <input
                                v-model="form.participants"
                                :value="participant.id"
                                type="checkbox"
                                class="w-5 h-5 rounded border-gray-300 dark:border-gray-600
                                    bg-white dark:bg-gray-700
                                    text-blue-600 focus:ring-blue-500
                                    dark:focus:ring-blue-400"
                            />
                        </label>
                    </div>

                    <div class="mt-6">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? 'Menyimpan...'
                                    : 'Simpan Absensi'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>