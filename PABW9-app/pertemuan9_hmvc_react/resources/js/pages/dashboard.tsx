import { useSharedProps } from '@/hooks/use-shared-props';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { ClipboardList, ShieldCheck, Users } from 'lucide-react';

type DashboardProps = {
    totalPendaftar: number;
    totalUsers: number | null;
};

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];

export default function Dashboard({ totalPendaftar, totalUsers }: DashboardProps) {
    const { user, isAdmin } = useSharedProps();

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex flex-1 flex-col gap-4 p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border rounded-xl border p-6">
                    <h1 className="text-xl font-semibold">Selamat datang, {user.name}!</h1>
                    <p className="text-muted-foreground mt-1 flex items-center gap-2 text-sm">
                        <ShieldCheck className="size-4" />
                        Anda login sebagai {isAdmin ? 'Admin' : 'User'}.
                    </p>
                </div>
                <div className="grid gap-4 md:grid-cols-2">
                    <Link
                        href="/pendaftaran"
                        className="border-sidebar-border/70 hover:bg-accent dark:border-sidebar-border rounded-xl border p-6 transition"
                    >
                        <ClipboardList className="text-muted-foreground size-6" />
                        <p className="mt-4 text-3xl font-bold">{totalPendaftar}</p>
                        <p className="text-muted-foreground text-sm">Jumlah pendaftar</p>
                    </Link>
                    {isAdmin && totalUsers !== null && (
                        <Link
                            href="/admin/users"
                            className="border-sidebar-border/70 hover:bg-accent dark:border-sidebar-border rounded-xl border p-6 transition"
                        >
                            <Users className="text-muted-foreground size-6" />
                            <p className="mt-4 text-3xl font-bold">{totalUsers}</p>
                            <p className="text-muted-foreground text-sm">Jumlah user</p>
                        </Link>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}