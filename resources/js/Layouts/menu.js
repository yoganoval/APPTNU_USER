export const menus = [
    {
        label: 'Dashboard',
        icon: 'home',
        href: route('dashboard'),
        permission: 'dashboard.view',
    },
    {
        label: 'User Management',
        icon: 'users',
        href: route('admin.users.index'),
        permission: 'user.view',
    },
    {
        label: 'Role Management',
        icon: 'shield',
        href: route('admin.roles.index'),
        permission: 'role.view',
    },
    {
        label: 'Permission',
        icon: 'lock',
        href: route('admin.permissions.index'),
        permission: 'permission.view',
    },

    // 🔥 CERTIFICATE TEMPLATE (FIXED)
    {
        label: 'Certificate Template',
        icon: 'file-text',
        href: route('admin.certificate.templates.index'),
        permission: 'certificate.template.view',
    },

    // 🔥 CERTIFICATE GENERATE
    {
        label: 'Certificates',
        icon: 'award',
        href: route('admin.certificates.index'),
        permission: 'certificate.generate',
    }
]