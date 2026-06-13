<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTicketRbacSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRoles();
        $this->seedPermissions();
        $this->mapRolePermissions();
        $this->seedMenus();
        $this->seedEventRoles();
        $this->seedEventCategories();
    }

    /**
     * 1. Tambah role baru untuk sistem tiket.
     * Role "User" / "SuperAdmin" existing tidak diubah.
     */
    private function seedRoles(): void
    {
        $roles = [
            ['name' => 'Event Manager', 'slug' => 'event-manager'],
            ['name' => 'Finance Event', 'slug' => 'finance-event'],
            ['name' => 'Check-in Officer', 'slug' => 'checkin-officer'],
            ['name' => 'Customer', 'slug' => 'customer'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $role['slug']],
                array_merge($role, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    /**
     * 2. Tambah permission baru untuk modul event/tiket/transaksi.
     * Mengikuti pola penamaan slug "modul.aksi" seperti permission existing.
     */
    private function seedPermissions(): void
    {
        $permissions = [
            // Event
            ['name' => 'Lihat Event', 'slug' => 'events.view'],
            ['name' => 'Buat Event', 'slug' => 'events.create'],
            ['name' => 'Edit Event', 'slug' => 'events.edit'],
            ['name' => 'Hapus Event', 'slug' => 'events.delete'],
            ['name' => 'Verifikasi Event', 'slug' => 'events.approve'],

            // Kategori event
            ['name' => 'Lihat Kategori Event', 'slug' => 'event-categories.view'],
            ['name' => 'Kelola Kategori Event', 'slug' => 'event-categories.manage'],

            // Jenis tiket
            ['name' => 'Lihat Jenis Tiket', 'slug' => 'event-tickets.view'],
            ['name' => 'Kelola Jenis Tiket', 'slug' => 'event-tickets.manage'],

            // Staff event
            ['name' => 'Kelola Staff Event', 'slug' => 'event-staffs.manage'],

            // Pesanan
            ['name' => 'Lihat Pesanan', 'slug' => 'orders.view'],
            ['name' => 'Export Pesanan', 'slug' => 'orders.export'],

            // Pembayaran
            ['name' => 'Lihat Pembayaran', 'slug' => 'payments.view'],

            // Refund
            ['name' => 'Lihat Refund', 'slug' => 'refunds.view'],
            ['name' => 'Approve Refund', 'slug' => 'refunds.approve'],

            // Peserta & check-in
            ['name' => 'Lihat Peserta', 'slug' => 'attendees.view'],
            ['name' => 'Scan Check-in', 'slug' => 'checkins.scan'],
            ['name' => 'Lihat Daftar Check-in', 'slug' => 'checkins.view'],

            // Laporan
            ['name' => 'Lihat Laporan', 'slug' => 'reports.view'],
            ['name' => 'Export Laporan', 'slug' => 'reports.export'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => $permission['slug']],
                array_merge($permission, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    /**
     * 3. Mapping role -> permission.
     * - superadmin   : dapat semua permission (existing + baru)
     * - event-manager: kelola event, kategori, jenis tiket, lihat peserta & laporan
     * - finance-event: lihat pesanan/pembayaran/refund, approve refund, laporan
     * - checkin-officer: scan & lihat check-in, lihat peserta
     * - customer     : tidak ada akses panel admin (akses frontend saja)
     */
    private function mapRolePermissions(): void
    {
        $allPermissionSlugs = DB::table('permissions')->pluck('slug')->toArray();

        $roleSlugToPermissionSlugs = [
            'superadmin' => $allPermissionSlugs,
            'event-manager' => [
                'events.view', 'events.create', 'events.edit', 'events.delete',
                'event-categories.view',
                'event-tickets.view', 'event-tickets.manage',
                'event-staffs.manage',
                'attendees.view',
                'reports.view',
            ],
            'finance-event' => [
                'orders.view', 'orders.export',
                'payments.view',
                'refunds.view', 'refunds.approve',
                'reports.view', 'reports.export',
            ],
            'checkin-officer' => [
                'checkins.view', 'checkins.scan',
                'attendees.view',
            ],
            'customer' => [],
        ];

        foreach ($roleSlugToPermissionSlugs as $roleSlug => $permissionSlugs) {
            $roleId = DB::table('roles')->where('slug', $roleSlug)->value('id');

            if (! $roleId || empty($permissionSlugs)) {
                continue;
            }

            $permissionIds = DB::table('permissions')
                ->whereIn('slug', $permissionSlugs)
                ->pluck('id');

            foreach ($permissionIds as $permissionId) {
                DB::table('role_permission')->updateOrInsert([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }

    /**
     * 4. Tambah menu sidebar baru + assign ke role SuperAdmin.
     * Idempotent: tidak membuat duplikat jika dijalankan ulang.
     */
    private function seedMenus(): void
    {
        $eventGroup = $this->menu('Event Management', null, 'ti ti-calendar-event', null, 10);
        $this->menu('Kategori Event', '/event-categories', 'ti ti-tags', $eventGroup, 1);
        $this->menu('Daftar Event', '/events', 'ti ti-calendar', $eventGroup, 2);
        $this->menu('Verifikasi Event', '/events/verification', 'ti ti-shield-check', $eventGroup, 3);
        $this->menu('Jenis Tiket', '/event-tickets', 'ti ti-ticket', $eventGroup, 4);
        $this->menu('Staff Event', '/event-staffs', 'ti ti-users-group', $eventGroup, 5);

        $transactionGroup = $this->menu('Transaksi', null, 'ti ti-receipt', null, 11);
        $this->menu('Daftar Pesanan', '/orders', 'ti ti-shopping-cart', $transactionGroup, 1);
        $this->menu('Pembayaran', '/payments', 'ti ti-credit-card', $transactionGroup, 2);
        $this->menu('Refund', '/refunds', 'ti ti-receipt-refund', $transactionGroup, 3);

        $checkinGroup = $this->menu('Check-in', null, 'ti ti-qrcode', null, 12);
        $this->menu('Scan Tiket', '/checkins/scan', 'ti ti-scan', $checkinGroup, 1);
        $this->menu('Daftar Peserta', '/attendees', 'ti ti-users', $checkinGroup, 2);

        $this->menu('Laporan Tiket', '/reports', 'ti ti-report', null, 13);

        // Assign semua menu baru ke SuperAdmin
        $superAdminId = DB::table('roles')->where('slug', 'superadmin')->value('id');

        $newMenuNames = [
            'Event Management', 'Kategori Event', 'Daftar Event', 'Verifikasi Event', 'Jenis Tiket', 'Staff Event',
            'Transaksi', 'Daftar Pesanan', 'Pembayaran', 'Refund',
            'Check-in', 'Scan Tiket', 'Daftar Peserta',
            'Laporan Tiket',
        ];

        $newMenuIds = DB::table('menus')->whereIn('name', $newMenuNames)->pluck('id');

        foreach ($newMenuIds as $menuId) {
            DB::table('menu_role')->updateOrInsert([
                'menu_id' => $menuId,
                'role_id' => $superAdminId,
            ]);
        }
    }

    /**
     * Helper: buat menu jika belum ada (dicocokkan dari name + parent_id), return id-nya.
     */
    private function menu(string $name, ?string $url, ?string $icon, ?int $parentId, int $order): int
    {
        $existing = DB::table('menus')
            ->where('name', $name)
            ->where('parent_id', $parentId)
            ->first();

        if ($existing) {
            return $existing->id;
        }

        return DB::table('menus')->insertGetId([
            'name' => $name,
            'url' => $url,
            'icon' => $icon,
            'parent_id' => $parentId,
            'order' => $order,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * 5. Data master event_roles (role operasional per-event di tabel event_staffs).
     * Ini terpisah dari tabel roles global - satu user bisa punya
     * event_role berbeda di event yang berbeda.
     */
    private function seedEventRoles(): void
    {
        $eventRoles = [
            ['name' => 'Event Manager', 'slug' => 'event-manager'],
            ['name' => 'Finance Event', 'slug' => 'finance-event'],
            ['name' => 'Check-in Officer', 'slug' => 'checkin-officer'],
        ];

        foreach ($eventRoles as $role) {
            DB::table('event_roles')->updateOrInsert(
                ['slug' => $role['slug']],
                array_merge($role, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    /**
     * 6. Data master kategori event (contoh awal, silakan disesuaikan/ditambah).
     */
    private function seedEventCategories(): void
    {
        $categories = [
            ['name' => 'Seminar', 'slug' => 'seminar'],
            ['name' => 'Workshop', 'slug' => 'workshop'],
            ['name' => 'Konser', 'slug' => 'konser'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Festival', 'slug' => 'festival'],
            ['name' => 'Lainnya', 'slug' => 'lainnya'],
        ];

        foreach ($categories as $category) {
            DB::table('event_categories')->updateOrInsert(
                ['slug' => $category['slug']],
                array_merge($category, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
