<script setup>
defineProps({
  events: Array
})
</script>

<template>
  <div>
    <h1>Certificates</h1>

    <div v-for="event in events" :key="event.id">
      <p>{{ event.title }}</p>

      <a :href="`/admin/certificates/download/${event.id}`">
        Download Sertifikat
      </a>
    </div>
  </div>
</template>