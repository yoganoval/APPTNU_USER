<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    anggota: Array
})
</script>

<template>
    <div class="p-6">

        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">
                Data Anggota
            </h1>

            <Link
                href="/anggota/create"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Tambah
            </Link>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">No</th>
                        <th class="border p-2">ID Anggota</th>
                        <th class="border p-2">Nama Perpustakaan</th>
                        <th class="border p-2">Wilayah</th>
                        <th class="border p-2">Jenis</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="(item, index) in anggota"
                        :key="item.id"
                    >
                        <td class="border p-2">
                            {{ index + 1 }}
                        </td>

                        <td class="border p-2">
                            {{ item.id_anggota }}
                        </td>

                        <td class="border p-2">
                            {{ item.nama_perpustakaan }}
                        </td>

                        <td class="border p-2">
                            {{ item.wilayah }}
                        </td>

                        <td class="border p-2">
                            {{ item.jenis_perpustakaan }}
                        </td>

                        <td class="border p-2 flex gap-2">
                            <Link
                                :href="`/anggota/${item.id}/edit`"
                                class="bg-yellow-500 text-white px-3 py-1 rounded"
                            >
                                Edit
                            </Link>

                            <Link
                                :href="`/anggota/${item.id}`"
                                method="delete"
                                as="button"
                                class="bg-red-500 text-white px-3 py-1 rounded"
                            >
                                Hapus
                            </Link>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>
</template>