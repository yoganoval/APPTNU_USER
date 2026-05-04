<script setup>
import { ref } from 'vue'

const fields = ref([])

// ➕ tambah field dinamis
const addDynamicField = (key) => {
  fields.value.push({
    id: null,
    field_name: key,
    text: null,
    x: 100,
    y: 100,
    fontSize: 24,
    fontColor: '#000000',
    fontWeight: 'normal'
  })
}

// ➕ tambah text statis
const addStaticText = () => {
  fields.value.push({
    id: null,
    field_name: null,
    text: 'Teks bebas',
    x: 100,
    y: 100,
    fontSize: 24,
    fontColor: '#000000',
    fontWeight: 'normal'
  })
}
</script>

<template>
  <div>

    <!-- 🔥 TOOLBAR -->
    <div style="margin-bottom: 10px;">
      <button @click="addDynamicField('name')">+ Nama</button>
      <button @click="addDynamicField('event')">+ Event</button>
      <button @click="addDynamicField('number')">+ Nomor</button>
      <button @click="addStaticText">+ Text</button>
    </div>

    <!-- 🔥 CANVAS -->
    <div style="
        position: relative;
        width: 800px;
        height: 500px;
        border: 1px solid #ccc;
        background: #f9f9f9;
    ">

      <!-- LOOP FIELD -->
      <div
        v-for="(f, i) in fields"
        :key="i"
        :style="{
          position: 'absolute',
          left: f.x + 'px',
          top: f.y + 'px',
          fontSize: f.fontSize + 'px',
          color: f.fontColor,
          fontWeight: f.fontWeight,
          cursor: 'move'
        }"
      >
        <!-- 🔥 PREVIEW -->
        {{ f.field_name ? '{' + f.field_name + '}' : f.text }}
      </div>

    </div>

  </div>
</template> 