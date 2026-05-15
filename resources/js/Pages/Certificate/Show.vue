<script setup>
import { ref } from 'vue'
import html2canvas from 'html2canvas'
import jsPDF from 'jspdf'

const props = defineProps({
    certificate: Object
})

const certificateRef = ref(null)

// Mapping value field
const getValue = (field) => {

    if (field.type === 'static') {
        return field.text
    }

    switch (field.field_name) {

        case 'nama':
            return props.certificate.user.name

        case 'event':
            return props.certificate.event.title

        case 'tanggal':
            return props.certificate.event.date

        case 'nomor':
            return `CERT-${props.certificate.id}`

        default:
            return ''
    }
}

// Download PDF
const downloadPDF = async () => {

    const element = certificateRef.value

    const canvas = await html2canvas(element, {
        scale: 2
    })

    const imgData = canvas.toDataURL('image/png')

    const pdf = new jsPDF({
        orientation: 'landscape',
        unit: 'px',
        format: [1200, 800]
    })

    pdf.addImage(
        imgData,
        'PNG',
        0,
        0,
        1200,
        800
    )

    pdf.save(`certificate-${props.certificate.id}.pdf`)
}
</script>

<template>

    <div class="min-h-screen bg-gray-100 py-10">

        <!-- Button -->
        <div class="flex justify-center mb-6">

            <button
                @click="downloadPDF"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded shadow"
            >
                Download PDF
            </button>

        </div>

        <!-- Certificate -->
        <div class="flex justify-center">

            <div
                ref="certificateRef"
                class="relative shadow-lg"
            >

                <!-- Background -->
                <img
                    :src="`/storage/${certificate.template.background_image}`"
                    class="w-[1200px]"
                />

                <!-- Fields -->
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

    </div>

</template>