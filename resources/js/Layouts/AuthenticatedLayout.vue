<script setup>
import { computed, ref } from 'vue'
import { Link, usePage, useForm } from '@inertiajs/vue3'
import { menus } from '@/Layouts/menu'
import Icon from '@/Components/Icon.vue'

const sidebarOpen = ref(true)
const page = usePage()

const user = computed(() => page.props.auth.user)

const logoutForm = useForm({})
const logout = () => {
    logoutForm.post(route('logout'))
}

const can = (permission) => {
    return user.value?.permissions?.includes(permission)
}


const filteredMenus = computed(() =>
    menus.filter(menu => can(menu.permission))
)

const isDark = ref(localStorage.getItem('dark') === 'true')

if (isDark.value) {
    document.documentElement.classList.add('dark')
}

const toggleDark = () => {
    isDark.value = !isDark.value

    document.documentElement.classList.toggle('dark', isDark.value)
    localStorage.setItem('dark', isDark.value)
}
</script>

<template>
<div class="flex h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">

    <!-- SIDEBAR -->
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-20'"
        class="flex-shrink-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700
        transition-all duration-300 flex flex-col"
    >

        <!-- LOGO -->
        <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 px-4">
            <img
                src="/images/logo-apptnu.png"
                :class="sidebarOpen ? 'h-8' : 'h-5'"
                class="w-auto object-contain transition-all duration-300"
            />
        </div>

        <!-- MENU -->
        <nav class="flex-1 p-2 space-y-1">
            <Link
                v-for="menu in filteredMenus"
                :key="menu.label"
                :href="menu.href"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                       text-gray-700 dark:text-gray-200
                       hover:bg-gray-100 dark:hover:bg-gray-700
                       hover:text-gray-900 dark:hover:text-white
                       transition"
                :class="!sidebarOpen ? 'justify-center' : ''"
            >
                <Icon :name="menu.icon" />
                <span v-if="sidebarOpen">{{ menu.label }}</span>
            </Link>
        </nav>

        <!-- LOGOUT -->
        <div class="p-2 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <button
                @click="logout"
                class="w-full flex items-center gap-2 px-3 py-2 rounded-lg
                       text-red-500 dark:text-red-400
                       hover:bg-red-50 dark:hover:bg-red-900/30
                       transition"
                :class="!sidebarOpen ? 'justify-center' : ''"
            >
                <span>⎋</span>
                <span v-if="sidebarOpen">Logout</span>
            </button>
        </div>

    </aside>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 transition">

            <!-- LEFT -->
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition"
            >
                ☰
            </button>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                <!-- DARK MODE -->
                <button
                    @click="toggleDark"
                    class="w-9 h-9 flex items-center justify-center rounded-full
                           bg-gray-200 dark:bg-gray-700
                           text-gray-700 dark:text-gray-200
                           hover:scale-105 transition"
                >
                    <span v-if="isDark">☀️</span>
                    <span v-else>🌙</span>
                </button>

                <!-- USER -->
                <div class="text-gray-700 dark:text-gray-200 font-medium">
                    {{ user?.name }}
                </div>

            </div>

        </header>

        <!-- HEADER SLOT -->
        <div v-if="$slots.header"
             class="p-6 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 transition">
            <slot name="header" />
        </div>

        <!-- MAIN -->
        <main class="flex-1 p-6 overflow-y-auto text-gray-800 dark:text-gray-100 transition">
            <slot />
        </main>

    </div>

</div>
</template>