<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    login: '', // 🔥 ganti dari email
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login APPTNU" />

    <div class="h-screen flex items-center justify-center bg-gradient-to-br from-emerald-900 via-emerald-800 to-green-700 overflow-hidden">

        <div class="w-full max-w-sm px-4">

            <!-- CARD -->
            <div class="bg-white/95 rounded-xl shadow-2xl overflow-hidden">

                <!-- HEADER -->
                <div class="bg-gradient-to-r from-emerald-700 to-green-600 py-5 text-center">
                    <h1 class="text-xl font-bold text-white">APPTNU</h1>
                    <p class="text-emerald-100 text-xs">Masuk ke sistem</p>
                </div>

                <!-- BODY -->
                <div class="px-6 py-5">

                    <!-- STATUS -->
                    <div v-if="status" class="mb-3 text-xs text-green-600 text-center">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-3">

                        <!-- LOGIN (EMAIL / ID ANGGOTA) -->
                        <div>
                            <input
                                type="text"
                                v-model="form.login"
                                placeholder="Email / ID Anggota"
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none"
                                :class="{ 'border-red-500': form.errors.login }"
                                required
                            />
                            <p v-if="form.errors.login" class="text-red-500 text-xs mt-1">
                                {{ form.errors.login }}
                            </p>

                            <!-- HINT -->
                            <p class="text-[10px] text-gray-500 mt-1">
                                Gunakan email atau ID anggota
                            </p>
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <input
                                type="password"
                                v-model="form.password"
                                placeholder="Password"
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none"
                                :class="{ 'border-red-500': form.errors.password }"
                                required
                            />
                            <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- REMEMBER -->
                        <div class="flex items-center justify-between text-xs">
                            <label class="flex items-center gap-1">
                                <input type="checkbox" v-model="form.remember" />
                                Ingat
                            </label>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-emerald-600 hover:underline"
                            >
                                Lupa?
                            </Link>
                        </div>

                        <!-- BUTTON -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg text-sm transition disabled:opacity-50"
                        >
                            {{ form.processing ? 'Loading...' : 'Masuk' }}
                        </button>

                        <!-- REGISTER -->
                        <div class="text-center text-xs mt-2">
                            Belum punya akun?
                            <Link href="/register" class="text-emerald-600 font-semibold">
                                Daftar
                            </Link>
                        </div>

                    </form>
                </div>
            </div>

            <!-- FOOTER -->
            <p class="text-center text-white/60 text-[10px] mt-3">
                © 2026 APPTNU
            </p>

        </div>
    </div>
</template>