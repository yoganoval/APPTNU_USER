<script setup>
import { ref, onMounted, watch } from 'vue'
import { usePage, router, Head } from '@inertiajs/vue3'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const page = usePage()
const template = page.props.template ?? null
const templateId = template?.id ?? null

/* =========================
   BASE SIZE
========================= */
const baseWidth = 1200
const baseHeight = 800

/* =========================
   CANVAS
========================= */
const stageConfig = ref({
  width: 0,
  height: 0
})

const scale = ref(1)

const bgConfig = ref({
  x: 0,
  y: 0,
  width: 0,
  height: 0,
  image: null
})

/* =========================
   FIELDS
========================= */
const fields = ref([])

/* =========================
   LOAD DATA + RESIZE
========================= */
onMounted(() => {

  const resize = () => {
    const container = document.querySelector('.max-w-7xl')
    const containerWidth = container?.clientWidth || window.innerWidth

    const width = Math.min(containerWidth - 20, window.innerWidth - 20)
    scale.value = width / baseWidth

    stageConfig.value.width = width
    stageConfig.value.height = baseHeight * scale.value

    bgConfig.value.width = stageConfig.value.width
    bgConfig.value.height = stageConfig.value.height
  }

  window.addEventListener('resize', resize)
  resize()

  // LOAD TEMPLATE
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
      text: f.text,
      type: f.type,
      x: f.x,
      y: f.y,
      fontSize: f.font_size || 24,
      fontColor: f.font_color || '#000000',
      fontWeight: f.font_weight || 'normal',
      draggable: true
    }))
  }
})

/* =========================
   ACTIONS
========================= */
function addField() {
  fields.value.push({
    id: null,
    field_name: null,
    text: 'TEXT BARU',
    type: 'static',
    x: 300,
    y: 200,
    fontSize: 24,
    fontColor: '#000000',
    fontWeight: 'normal',
    draggable: true
  })
}

function removeField(index) {
  fields.value.splice(index, 1)
}

function updatePosition(index, e) {
  const node = e.target

  fields.value[index].x = node.x() / scale.value
  fields.value[index].y = node.y() / scale.value
}

async function saveAll() {
  try {
    await axios.post('/admin/certificate-fields', {
      template_id: templateId,
      fields: fields.value.map(f => ({
        id: f.id,
        field_name: f.field_name,
        text: f.text,
        type: f.field_name ? 'dynamic' : 'static',
        x: f.x,
        y: f.y,
        fontSize: f.fontSize,
        fontColor: f.fontColor,
        fontWeight: f.fontWeight
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
            <div class="mx-auto w-full max-w-7xl px-4">

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
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow overflow-hidden flex justify-center">
                    <v-stage :config="{
                      width: stageConfig.width,
                      height: stageConfig.height,
                      scaleX: scale,
                      scaleY: scale
                    }">

                        <v-layer>
                            <v-image :config="{
                              ...bgConfig,
                              width: stageConfig.width,
                              height: stageConfig.height
                            }" />
                        </v-layer>

                        <v-layer>
                            <v-text
                              v-for="(field, index) in fields"
                              :key="field.id ?? index"
                              :config="{
                                text: field.text || field.field_name,
                                x: field.x * scale,
                                y: field.y * scale,
                                fontSize: field.fontSize * scale,
                                fill: field.fontColor,
                                fontStyle: field.fontWeight === 'bold' ? 'bold' : 'normal'
                              }"
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