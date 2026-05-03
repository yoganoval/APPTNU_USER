<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'

const page = usePage()

// 🔥 ambil dari backend
const template = page.props.template

const templateId = template.id

// canvas
const stageConfig = {
  width: 1200,
  height: 800
}

// background
const bgConfig = ref({
  x: 0,
  y: 0,
  width: 1200,
  height: 800,
  image: null
})

// default text
const nameText = ref({
  x: 400,
  y: 300,
  text: 'NAMA PESERTA',
  fontSize: 32,
  fill: '#000',
  draggable: true
})

const eventText = ref({
  x: 400,
  y: 400,
  text: 'NAMA EVENT',
  fontSize: 24,
  fill: '#333',
  draggable: true
})

/* =========================
   LOAD DATA
========================= */
onMounted(() => {

  // 🔥 LOAD BACKGROUND DINAMIS
  const image = new window.Image()
  image.src = `/storage/${template.background}`

  image.onload = () => {
    bgConfig.value.image = image
  }

  // 🔥 LOAD FIELD POSITION
  template.fields.forEach(field => {
    if (field.field_name === 'name') {
      nameText.value.x = field.x
      nameText.value.y = field.y
      nameText.value.fontSize = field.font_size
    }

    if (field.field_name === 'event') {
      eventText.value.x = field.x
      eventText.value.y = field.y
      eventText.value.fontSize = field.font_size
    }
  })
})

/* =========================
   SAVE POSITION
========================= */
function updatePosition(field, e) {
  const node = e.target

  axios.post('/admin/certificate-fields', {
    certificate_template_id: templateId,
    field_name: field,
    x: node.x(),
    y: node.y(),
    font_size: node.fontSize ? node.fontSize() : 24
  })
}

</script>

<template>
<div class="p-4">

  <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
    Editor: {{ template.name }}
  </h2>

  <v-stage :config="stageConfig">

    <!-- BACKGROUND -->
    <v-layer>
      <v-image :config="bgConfig" />
    </v-layer>

    <!-- TEXT -->
    <v-layer>

      <!-- NAME -->
      <v-text
        :config="nameText"
        draggable
        @dragend="updatePosition('name', $event)"
      />

      <!-- EVENT -->
      <v-text
        :config="eventText"
        draggable
        @dragend="updatePosition('event', $event)"
      />

    </v-layer>

  </v-stage>

</div>
</template>