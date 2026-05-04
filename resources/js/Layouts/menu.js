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

    // 🔥 TAMBAHAN SERTIFIKAT
    {
        label: 'Certificate Template',
        icon: 'file-text',
        href: '/admin/certificate-templates', // nanti route inertia
        permission: 'certificate.view',
    },

    {
        label: 'Certificates',
        icon: 'award',
        href: route('admin.certificates.index'),
        permission: 'certificate.generate',
    }
]
