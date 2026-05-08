<script setup>
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import axios from 'axios'

const props = defineProps({
    template: Object
})

/* =========================
   TEMPLATE
========================= */
const template = props.template || {}

/* =========================
   STAGE
========================= */
const stageConfig = {
    width: 1200,
    height: 850
}

const scale = ref(1)

/* =========================
   BACKGROUND IMAGE
========================= */
const bgImage = ref(null)

const bgConfig = ref({
    image: null
})

onMounted(() => {

    // LOAD BACKGROUND
    const image = new window.Image()

    image.src = `/storage/${template.background}`

    image.onload = () => {
        bgImage.value = image

        bgConfig.value = {
            image: image
        }
    }
})

/* =========================
   FIELDS
========================= */
const fields = ref(template.fields || [])

/* =========================
   ADD FIELD
========================= */
const addField = () => {
    fields.value.push({
        type: 'static',
        text: 'TEXT BARU',
        field_name: '',
        x: 100,
        y: 100,
        fontSize: 28,
        fontColor: '#000000',
        fontWeight: 'normal'
    })
}

/* =========================
   REMOVE FIELD
========================= */
const removeField = (index) => {
    fields.value.splice(index, 1)
}

/* =========================
   UPDATE POSITION
========================= */
const updatePosition = (index, e) => {
    fields.value[index].x = e.target.x()
    fields.value[index].y = e.target.y()
}

/* =========================
   SAVE
========================= */
const saveAll = async () => {

    try {

        await axios.post('/certificate-fields', {
            template_id: template.id,
            fields: fields.value
        })

        alert('Berhasil disimpan')

    } catch (error) {

        console.log(error)

        alert('Gagal menyimpan')
    }
}
</script>

<template>
    <Head :title="`Editor: ${template?.name}`" />

    <AuthenticatedLayout>

        <!-- HEADER -->
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Editor: {{ template?.name }}
            </h2>
        </template>

        <div class="py-8">

            <div class="max-w-7xl mx-auto px-4">

                <!-- TOOLBAR -->
                <div class="mb-4 flex gap-2">

                    <button
                        @click="addField"
                        class="px-4 py-2 rounded bg-green-500 text-white hover:bg-green-600"
                    >
                        + Tambah Text
                    </button>

                    <button
                        @click="saveAll"
                        class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600"
                    >
                        💾 Simpan Semua
                    </button>

                </div>

                <!-- CANVAS -->
                <div class="bg-white dark:bg-gray-800 rounded shadow p-4 overflow-auto">

                    <div class="flex justify-center">

                        <v-stage
                            :config="{
                                width: stageConfig.width,
                                height: stageConfig.height,
                                scaleX: scale,
                                scaleY: scale
                            }"
                        >

                            <!-- BACKGROUND -->
                            <v-layer>

                                <v-image
                                    :config="{
                                        ...bgConfig,
                                        width: stageConfig.width,
                                        height: stageConfig.height
                                    }"
                                />

                            </v-layer>

                            <!-- TEXT -->
                            <v-layer>

                                <v-text
                                    v-for="(field, index) in fields"
                                    :key="field.id || index"
                                    :config="{
                                        text: field.type === 'dynamic'
                                            ? `{${field.field_name || 'field'}}`
                                            : field.text,

                                        x: field.x,
                                        y: field.y,

                                        fontSize: field.fontSize || 24,

                                        fill: field.fontColor || '#000000',

                                        fontStyle: field.fontWeight === 'bold'
                                            ? 'bold'
                                            : 'normal',

                                        draggable: true
                                    }"

                                    @dragmove="updatePosition(index, $event)"
                                    @dragend="updatePosition(index, $event)"
                                />

                            </v-layer>

                        </v-stage>

                    </div>

                </div>

                <!-- FIELD SETTINGS -->
                <div class="mt-6 space-y-4">

                    <div
                        v-for="(field, index) in fields"
                        :key="field.id || index"
                        class="bg-white dark:bg-gray-800 rounded shadow p-4"
                    >

                        <div class="grid grid-cols-1 md:grid-cols-6 gap-3">

                            <!-- TYPE -->
                            <div>
                                <label class="text-sm block mb-1">
                                    Type
                                </label>

                                <select
                                    v-model="field.type"
                                    class="w-full border rounded p-2 text-sm"
                                >
                                    <option value="static">
                                        Static
                                    </option>

                                    <option value="dynamic">
                                        Dynamic
                                    </option>
                                </select>
                            </div>

                            <!-- TEXT -->
                            <div v-if="field.type === 'static'">
                                <label class="text-sm block mb-1">
                                    Text
                                </label>

                                <input
                                    v-model="field.text"
                                    type="text"
                                    class="w-full border rounded p-2 text-sm"
                                />
                            </div>

                            <!-- FIELD -->
                            <div v-else>
                                <label class="text-sm block mb-1">
                                    Field
                                </label>

                                <select
                                    v-model="field.field_name"
                                    class="w-full border rounded p-2 text-sm"
                                >
                                    <option value="nama">Nama</option>
                                    <option value="event">Event</option>
                                    <option value="tanggal">Tanggal</option>
                                    <option value="nomor">Nomor</option>
                                </select>
                            </div>

                            <!-- FONT SIZE -->
                            <div>
                                <label class="text-sm block mb-1">
                                    Font Size
                                </label>

                                <input
                                    v-model="field.fontSize"
                                    type="number"
                                    class="w-full border rounded p-2 text-sm"
                                />
                            </div>

                            <!-- COLOR -->
                            <div>
                                <label class="text-sm block mb-1">
                                    Color
                                </label>

                                <input
                                    v-model="field.fontColor"
                                    type="color"
                                    class="w-full h-10 border rounded"
                                />
                            </div>

                            <!-- WEIGHT -->
                            <div>
                                <label class="text-sm block mb-1">
                                    Weight
                                </label>

                                <select
                                    v-model="field.fontWeight"
                                    class="w-full border rounded p-2 text-sm"
                                >
                                    <option value="normal">
                                        Normal
                                    </option>

                                    <option value="bold">
                                        Bold
                                    </option>
                                </select>
                            </div>

                            <!-- DELETE -->
                            <div class="flex items-end">

                                <button
                                    @click="removeField(index)"
                                    class="px-3 py-2 rounded bg-red-500 text-white hover:bg-red-600"
                                >
                                    Hapus
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>