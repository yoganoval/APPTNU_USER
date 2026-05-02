<script setup>
import { useForm } from '@inertiajs/vue3'

defineProps({
    permissions: Array
})

const form = useForm({
    name: ''
})

const submit = () => {
    form.post(route('permissions.store'), {
        onSuccess: () => form.reset()
    })
}
</script>

<template>
<div class="p-6">

    <h1 class="text-xl font-bold mb-4">Permissions</h1>

    <div class="bg-white p-4 rounded shadow mb-6">
        <input v-model="form.name"
               placeholder="permission.name"
               class="border p-2 w-full mb-2">

        <button @click="submit"
                class="bg-green-500 text-white px-4 py-2">
            Add Permission
        </button>
    </div>

    <div v-for="p in permissions" :key="p.id"
         class="p-2 bg-gray-100 mb-2 rounded">
        {{ p.name }}
    </div>

</div>
</template>