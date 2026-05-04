<script setup>
const props = defineProps({
    certificate: Object
});

// 🔥 Mapping value field
const getValue = (field) => {
    if (field.type === 'static') return field.text;

    switch (field.field_name) {
        case 'nama':
            return props.certificate.user.name;

        case 'event':
            return props.certificate.event.title;

        case 'tanggal':
            return props.certificate.event.date;

        case 'nomor':
            return `CERT-${props.certificate.id}`;

        default:
            return '';
    }
};
</script>

<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        
        <!-- Container Sertifikat -->
        <div class="relative shadow-lg">

            <!-- Background -->
            <img
                :src="`/storage/${certificate.template.background}`"
                class="w-[800px]"
            />

            <!-- Field Text -->
            <div
                v-for="field in certificate.template.fields"
                :key="field.id"
                class="absolute"
                :style="{
                    left: field.x + 'px',
                    top: field.y + 'px',
                    fontSize: field.font_size + 'px',
                    color: field.font_color,
                    fontWeight: field.font_weight
                }"
            >
                {{ getValue(field) }}
            </div>

        </div>

    </div>
</template>