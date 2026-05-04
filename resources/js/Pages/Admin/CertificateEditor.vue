<script setup>
import { ref, onMounted, watch } from 'vue'
import { usePage, router, Head } from '@inertiajs/vue3'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const page = usePage()
const template = page.props.template ?? null
const templateId = template?.id ?? null

/* =========================
   CANVAS
========================= */
const stageConfig = {
  width: 1200,
  height: 800
}

const bgConfig = ref({
  x: 0,
  y: 0,
  width: 1200,
  height: 800,
  image: null
})

/* =========================
   FIELDS
========================= */
const fields = ref([])

/* =========================
   LOAD DATA
========================= */
onMounted(() => {
  if (!template) return

  const image = new window.Image()
  image.src = `/storage/${template.background_image}`
  image.onload = () => {
    bgConfig.value.image = image
  }

  if (template.fields && template.fields.length) {
    fields.value = template.fields.map(f => ({
      id: f.id,
      field_name: f.field_name,
      x: f.x,
      y: f.y,
      text: f.text || f.field_name,
      fontSize: f.font_size || 24,
      fill: '#000',
      draggable: true
    }))
  }
})

/* =========================
   SYNC TEXT
========================= */
watch(fields, (newFields) => {
  newFields.forEach(f => {
    f.text = f.field_name
  })
}, { deep: true })

/* =========================
   ACTIONS
========================= */
function addField() {
  fields.value.push({
    id: null,
    field_name: 'custom_' + fields.value.length,
    x: 300,
    y: 200,
    text: 'TEXT BARU',
    fontSize: 24,
    fill: '#000',
    draggable: true
  })
}

function removeField(index) {
  fields.value.splice(index, 1)
}

function updatePosition(index, e) {
  const node = e.target
  fields.value[index].x = node.x()
  fields.value[index].y = node.y()
}

async function saveAll() {
  try {
    await axios.post('/admin/certificate-fields', {
      template_id: templateId,
      fields: fields.value.map(f => ({
        id: f.id,
        field_name: f.field_name,
        x: f.x,
        y: f.y,
        fontSize: f.fontSize,
        text: f.text
      }))
    })

    router.visit(route('admin.certificate.templates.index'))

  } catch (e) {
    console.error(e)
    alert('Gagal simpan')
  }
}
</script>

<template>
    <Head :title="`Editor: ${template?.name || ''}`" />

    <AuthenticatedLayout>

        <!-- HEADER -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Editor: {{ template?.name }}
            </h2>
        </template>

        <!-- CONTENT -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <!-- TOOLBAR -->
                <div class="mb-4 flex gap-2">
                    <button
                        @click="addField"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded"
                    >
                        + Tambah Text
                    </button>

                    <button
                        @click="saveAll"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                    >
                        💾 Simpan Semua
                    </button>
                </div>

                <!-- CANVAS -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow overflow-auto">
                    <v-stage :config="stageConfig">

                        <v-layer>
                            <v-image :config="bgConfig" />
                        </v-layer>

                        <v-layer>
                            <v-text
                                v-for="(field, index) in fields"
                                :key="field.id ?? index"
                                :config="field"
                                draggable
                                @dragend="updatePosition(index, $event)"
                            />
                        </v-layer>

                    </v-stage>
                </div>

                <!-- FIELD LIST -->
                <div class="mt-4 space-y-2">
                    <div
                        v-for="(field, index) in fields"
                        :key="field.id ?? index"
                        class="flex items-center gap-2"
                    >
                        <input
                            v-model="field.field_name"
                            class="border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900
                                   text-gray-800 dark:text-gray-100
                                   p-1 text-sm rounded"
                        />

                        <button
                            @click="removeField(index)"
                            class="text-red-500 text-sm"
                        >
                            Hapus
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>