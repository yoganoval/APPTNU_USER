<script setup>
import { computed, ref } from 'vue'
import { Link, usePage, useForm } from '@inertiajs/vue3'

const sidebarOpen = ref(true)
const page = usePage()

// ✅ REACTIVE USER (INI FIX PENTING)
const user = computed(() => page.props.auth.user)

// logout
const logoutForm = useForm({})
const logout = () => {
    logoutForm.post(route('logout'))
}

// permission checker
const can = (permission) => {
    return user.value?.permissions?.includes(permission)
}

// menu
const menus = [
    {
        label: 'Dashboard',
        icon: '🏠',
        href: route('dashboard'),
        permission: 'dashboard.view',
    },
    {
        label: 'User Management',
        icon: '👤',
        href: route('admin.users.index'),
        permission: 'user.view',
    },
    {
        label: 'Role Management',
        icon: '🛡️',
        href: route('admin.roles.index'),
        permission: 'role.view',
    },
    {
        label: 'Permission',
        icon: '🔐',
        href: route('admin.permissions.index'),
        permission: 'permission.view',
    },
]

// filtered menu (FIX REACTIVE)
const filteredMenus = computed(() =>
    menus.filter(menu => can(menu.permission))
)
</script>

<template>
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">

    <!-- SIDEBAR -->
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-20'"
        class="flex-shrink-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700
        transition-all duration-300 flex flex-col"
    >

        <!-- LOGO -->
        <div class="h-16 flex items-center justify-center border-b px-4">
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
                @click="console.log('CLICK MENU:', menu.href)"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
                :class="!sidebarOpen ? 'justify-center' : ''"
            >
                <span>{{ menu.icon }}</span>
                <span v-if="sidebarOpen">{{ menu.label }}</span>
            </Link>
        </nav>

        <!-- LOGOUT -->
        <div class="p-2 border-t mt-auto">
            <button
                @click="logout"
                class="w-full flex items-center gap-2 px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg"
                :class="!sidebarOpen ? 'justify-center' : ''"
            >
                <span>⎋</span>
                <span v-if="sidebarOpen">Logout</span>
            </button>
        </div>

    </aside>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="h-16 bg-white dark:bg-gray-800 border-b dark:border-gray-700 flex items-center justify-between px-6">

            <button
                @click="sidebarOpen = !sidebarOpen"
                class="text-gray-600 dark:text-gray-300"
            >
                ☰
            </button>

            <div class="text-gray-700 dark:text-gray-200">
                {{ user?.name }}
            </div>
        </header>

        <!-- HEADER SLOT -->
        <div v-if="$slots.header" class="p-6 bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-700">
            <slot name="header" />
        </div>

        <!-- MAIN -->
        <main class="flex-1 p-6 overflow-y-auto">
            <slot />
        </main>

    </div>

</div>
</template>