import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, LayoutGrid, Users, BookMarked } from 'lucide-react';
import { usePage } from '@inertiajs/react';
import AppLogo from './app-logo';

const commonNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        url: '/dashboard',
        icon: LayoutGrid,
    },
];

export function AppSidebar() {
    const { auth } = usePage<any>().props;
    const mainNavItems: NavItem[] = [
        ...commonNavItems,
        { title: auth?.role === 'admin' ? 'Manajemen Buku' : 'Katalog Buku', url: auth?.role === 'admin' ? '/buku' : '/katalog', icon: BookMarked },
        { title: 'Peminjaman', url: '/peminjaman', icon: BookOpen },
        ...(auth?.role === 'admin' ? [{ title: 'Kelola Pengguna', url: '/pengguna', icon: Users }] : []),
    ];
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
