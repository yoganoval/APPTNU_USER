<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const step = ref(1)

const form = useForm({
    wilayah: '',
    jenis_perpustakaan: '',
    id_anggota: '',
    nama_perguruan_tinggi: '',

    nama_perpustakaan: '',
    alamat: '',
    email_perpustakaan: '',
    telp: '',
    fax: '',

    nama_kepala: '',
    email_kepala: '',
    wa_kepala: '',
    nama_pic: '',
    wa_pic: '',

    website: '',
    repository: '',
    facebook: '',
    twitter: '',
    instagram: '',
    blog: '',
    logo: null,
    surat: null,

    email: '',
    password: '',
    password_confirmation: '',
})

const nextStep = () => {
    if (step.value < 5) step.value++
}

const prevStep = () => {
    if (step.value > 1) step.value--
}

const submit = () => {
    form.post(route('register'), {
        forceFormData: true,
        onError: (err) => {
            console.log('ERROR VALIDASI:', err)
        }
    })
}

const provinsi = [
    'Jawa Timur','Jawa Tengah','Jawa Barat','DKI Jakarta','DI Yogyakarta',
    'Bali','Sumatera Utara','Sumatera Barat','Sumatera Selatan',
    'Kalimantan Timur','Kalimantan Selatan','Sulawesi Selatan',
]

const jenisPerpustakaan = [
    'Universitas','Institut','Sekolah Tinggi','Akademi','Politeknik',
]
</script>

<template>
<div class="flex h-screen overflow-hidden">

    <!-- LEFT PANEL - NU Green Gradient -->
    <div class="hidden md:flex w-1/2 bg-gradient-to-br from-green-900 via-green-800 to-emerald-700 text-white items-center justify-center relative overflow-hidden">
        <!-- Abstract background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-40 h-40 border-2 border-white/20 rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-60 h-60 border-2 border-white/20 rounded-full"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 border-2 border-white/10 rounded-full"></div>
        </div>
        
        <div class="relative z-10 text-center px-12">
            <div class="mb-6 inline-flex items-center justify-center w-24 h-24 bg-white/10 rounded-2xl backdrop-blur-sm">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-5xl font-bold mb-4 tracking-tight">Perpustakaan NU</h1>
            <p class="text-green-200 text-lg font-light">Sistem pendataan perpustakaan perguruan tinggi</p>
            <div class="mt-10 pt-8 border-t border-white/20">
                <p class="text-sm text-green-200/80">"Membaca adalah ibadah"</p>
                <p class="text-xs text-green-200/60 mt-2">Nahdlatul Ulama</p>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL - Registration Form (No Scroll) -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 overflow-hidden">
        <div class="w-full max-w-2xl">
            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-2xl shadow-green-900/10 border border-green-100 overflow-hidden">
                
                <!-- HEADER -->
                <div class="px-8 pt-8 pb-6 border-b border-green-100">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h1 class="text-2xl font-bold text-green-800 tracking-tight">
                                Pendaftaran
                            </h1>
                            <p class="text-green-600 text-sm mt-1">Lengkapi data perpustakaan Anda</p>
                        </div>
                        <span class="text-sm text-green-700 font-medium bg-green-100 px-3 py-1.5 rounded-full">
                            {{ step }} / 5
                        </span>
                    </div>
                    
                    <!-- Step Indicator NU Style -->
                    <div class="mt-6 flex items-center gap-2">
                        <div v-for="i in 5" :key="i" class="flex-1">
                            <div 
                                class="h-1.5 rounded-full transition-all duration-300"
                                :class="i <= step ? 'bg-green-600' : 'bg-green-100'">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-xs text-green-600" v-if="step >= 1">Institusi</span>
                        <span class="text-xs text-green-600" v-if="step >= 2">Perpustakaan</span>
                        <span class="text-xs text-green-600" v-if="step >= 3">Penanggung Jawab</span>
                        <span class="text-xs text-green-600" v-if="step >= 4">Media</span>
                        <span class="text-xs text-green-600" v-if="step >= 5">Akun</span>
                    </div>
                </div>

                <!-- BODY - Fixed height no scroll -->
                <div class="px-8 py-6" style="height: 460px;">
                    <form @submit.prevent="submit" class="h-full flex flex-col">
                        <!-- Scrollable content area with hidden scrollbar -->
                        <div class="flex-1 overflow-y-auto" style="scrollbar-width: thin;">
                            <!-- Panduan Card -->
                            <div v-if="step === 1" class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5 mb-6">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-green-800 mb-1">Panduan Pendaftaran</h3>
                                        <p class="text-sm text-green-700 mb-3">Download panduan dan template sebelum mengisi formulir.</p>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="/file/PENDAFTARAN ANGGOTA APPTNU.pdf" target="_blank"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 hover:bg-green-800 text-white text-sm rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Panduan
                                            </a>
                                            <a href="/file/Formulir-Pendaftaran-Keanggotaan-APPTNU-2026.docx" target="_blank"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Template
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 1 -->
                            <div v-if="step === 1" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Provinsi</label>
                                    <select v-model="form.wilayah" class="input">
                                        <option value="">Pilih Provinsi</option>
                                        <option v-for="p in provinsi" :key="p" :value="p">{{ p }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Jenis Perguruan Tinggi</label>
                                    <select v-model="form.jenis_perpustakaan" class="input">
                                        <option value="">Pilih Jenis</option>
                                        <option v-for="j in jenisPerpustakaan" :key="j" :value="j">{{ j }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">ID Anggota</label>
                                    <input v-model="form.id_anggota" class="input" placeholder="Masukkan ID Anggota" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Nama Perguruan Tinggi</label>
                                    <input v-model="form.nama_perguruan_tinggi" class="input" placeholder="Nama Lengkap PT" />
                                </div>
                            </div>

                            <!-- STEP 2 -->
                            <div v-if="step === 2" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Nama Perpustakaan</label>
                                    <input v-model="form.nama_perpustakaan" class="input" placeholder="Nama Perpustakaan" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Alamat</label>
                                    <textarea v-model="form.alamat" class="input" rows="2" placeholder="Alamat Lengkap"></textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">Email</label>
                                        <input v-model="form.email_perpustakaan" class="input" placeholder="email@perpustakaan.com" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">Telepon</label>
                                        <input v-model="form.telp" class="input" placeholder="Nomor Telepon" />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Fax</label>
                                    <input v-model="form.fax" class="input" placeholder="Nomor Fax" />
                                </div>
                            </div>

                            <!-- STEP 3 -->
                            <div v-if="step === 3" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Nama Kepala Perpustakaan</label>
                                    <input v-model="form.nama_kepala" class="input" placeholder="Nama Lengkap" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">Email Kepala</label>
                                        <input v-model="form.email_kepala" class="input" placeholder="email@domain.com" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">WhatsApp Kepala</label>
                                        <input v-model="form.wa_kepala" class="input" placeholder="+62 xxxx" />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Nama PIC</label>
                                    <input v-model="form.nama_pic" class="input" placeholder="Nama Person In Charge" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">WhatsApp PIC</label>
                                    <input v-model="form.wa_pic" class="input" placeholder="+62 xxxx" />
                                </div>
                            </div>

                            <!-- STEP 4 -->
                            <div v-if="step === 4" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">Website</label>
                                        <input v-model="form.website" class="input" placeholder="https://..." />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">Repository</label>
                                        <input v-model="form.repository" class="input" placeholder="Link Repository" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">Facebook</label>
                                        <input v-model="form.facebook" class="input" placeholder="Facebook URL" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-green-800 mb-1.5">Instagram</label>
                                        <input v-model="form.instagram" class="input" placeholder="Instagram URL" />
                                    </div>
                                </div>
                                <div class="border-t border-green-100 pt-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-green-800 mb-1.5">Logo Perpustakaan</label>
                                            <input type="file" class="input-file" @change="e => form.logo = e.target.files[0]" />
                                            <p class="text-xs text-green-500 mt-1">JPG, PNG (Max 2MB)</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-800 mb-1.5">Surat Pendaftaran</label>
                                            <input type="file" class="input-file" @change="e => form.surat = e.target.files[0]" />
                                            <p class="text-xs text-green-500 mt-1">PDF (Max 5MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 5 -->
                            <div v-if="step === 5" class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Email Login</label>
                                    <input v-model="form.email" type="email" class="input" placeholder="email@domain.com" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Password</label>
                                    <input v-model="form.password" type="password" class="input" placeholder="Minimal 8 karakter" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-green-800 mb-1.5">Konfirmasi Password</label>
                                    <input v-model="form.password_confirmation" type="password" class="input" placeholder="Ketik ulang password" />
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS - Fixed at bottom -->
                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-green-100">

                            <!-- LEFT SIDE -->
                            <div class="flex items-center gap-2">

                                <!-- 🔹 KEMBALI KE LOGIN -->
                                <a v-if="step === 1"
                                    :href="route('login')"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Login
                                </a>

                                <!-- 🔹 BUTTON BACK STEP -->
                                <button type="button" v-if="step > 1"
                                    @click="prevStep"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 text-green-700 bg-green-50 hover:bg-green-100 rounded-xl transition-all font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Kembali
                                </button>

                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="flex gap-2">

                                <button type="button" v-if="step < 5"
                                    @click="nextStep"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-700 hover:bg-green-800 text-white rounded-xl transition-all font-medium shadow-lg shadow-green-200">
                                    Selanjutnya
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>

                                <button v-if="step === 5"
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-700 hover:bg-green-800 text-white rounded-xl transition-all font-medium shadow-lg shadow-green-200 disabled:opacity-50">
                                    <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ form.processing ? 'Memproses...' : 'Daftar' }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Footer -->
            <p class="text-center text-green-600/60 text-xs mt-5">
                © 2026 Nahdlatul Ulama | Perpustakaan Digital
            </p>
        </div>
    </div>
</div>
</template>

<style scoped>
.input {
    @apply w-full px-4 py-2.5 rounded-xl border border-green-200 bg-green-50/30 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all text-green-800 placeholder:text-green-300;
}

.input-file {
    @apply w-full px-4 py-2 rounded-xl border border-green-200 bg-green-50/30 focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-green-700 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-100 file:text-green-700 hover:file:bg-green-200;
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f0fdf4;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #22c55e;
    border-radius: 10px;
}
</style>