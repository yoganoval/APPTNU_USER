<script setup>
import { useForm, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const form = useForm({
    name: '',
    background_image: null
})

const submit = () => {
    form.post(route('admin.certificate.templates.store'))
}
</script>

<template>
    <Head title="Tambah Template" />

    <AuthenticatedLayout>

        <!-- HEADER -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tambah Template
            </h2>
        </template>

        <!-- CONTENT -->
        <div class="py-12">
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">

                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <!-- NAME -->
                        <input
                            v-model="form.name"
                            placeholder="Nama Template"
                            class="border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900
                                   text-gray-800 dark:text-gray-100
                                   p-2 w-full mb-4 rounded"
                        />

                        <!-- UPLOAD -->
                        <input 
                            type="file" 
                            @change="e => form.background_image = e.target.files[0]"
                            class="mb-4 text-gray-800 dark:text-gray-100"
                        />

                        <!-- BUTTON -->
                        <button
                            @click="submit"
                            class="bg-green-500 hover:bg-green-600
                                   text-white px-4 py-2 rounded transition"
                        >
                            Simpan
                        </button>

                    </div>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>