<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    user: Object
})

const form = useForm({
    name: props.user.name,
    email: props.user.email
})

const submit = () => {
    form.put(`/admin/users/${props.user.id}`)
}
</script>

<template>
<div class="p-6 max-w-xl">
    <h1 class="text-xl font-bold mb-4">Edit User</h1>

    <form @submit.prevent="submit" class="space-y-4">
        <input v-model="form.name" class="w-full border p-2 rounded" />
        <input v-model="form.email" class="w-full border p-2 rounded" />

        <button class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
</template>