# Migration & Seeder Sistem Tiket Event (untuk project Laravel `tiketin`)

File ini berisi migration & seeder tambahan untuk membangun sistem penjualan tiket event
sesuai alur dan ERD yang Anda buat, **disesuaikan dengan struktur RBAC custom yang sudah ada**
(`users`, `roles`, `permissions`, `role_permission`, `user_role`, `menus`, `menu_role`).

## Cara pasang

1. Copy folder `database/migrations/*.php` ke `database/migrations/` project Laravel Anda.
2. Copy `database/seeders/EventTicketRbacSeeder.php` ke `database/seeders/` project Anda.
3. Jalankan migration:
   ```bash
   php artisan migrate
   ```
4. Jalankan seeder (akan menambah role, permission, menu, event_roles, dan kategori event):
   ```bash
   php artisan db:seed --class=EventTicketRbacSeeder
   ```
   Seeder ini idempotent (aman dijalankan berulang kali, tidak akan duplikat).

## Urutan migration (penting karena ada foreign key)

1. `event_categories`
2. `event_organizers` → FK `user_id` → `users.id`
3. `events` → FK `organizer_id` → `event_organizers.id`, `category_id` → `event_categories.id`
4. `event_roles`
5. `event_staffs` → FK `event_id`, `user_id` → `users.id`, `event_role_id` → `event_roles.id`
6. `event_tickets` → FK `event_id`
7. `orders` → FK `user_id` → `users.id` (customer), `event_id`
8. `order_items` → FK `order_id`, `ticket_id` → `event_tickets.id`
9. `attendees` → FK `order_item_id`
10. `checkins` → FK `attendee_id`, `officer_id` → `users.id`
11. `payments` → FK `order_id`
12. `refunds` → FK `order_id`

## Mapping RBAC

### Role global baru (tabel `roles`)
Ditambahkan ke `roles` existing (SuperAdmin, User tetap ada):

| Role | Slug | Keterangan |
|---|---|---|
| Event Manager | `event-manager` | Kelola event, kategori, jenis tiket, lihat peserta & laporan |
| Finance Event | `finance-event` | Lihat pesanan/pembayaran, kelola refund, laporan |
| Check-in Officer | `checkin-officer` | Scan & validasi tiket, lihat peserta |
| Customer | `customer` | Akses frontend pembelian tiket (tanpa akses panel admin) |

Assign role ke user tetap pakai cara existing Anda (kolom `users.role_id` dan/atau pivot
`user_role`) — seeder ini **tidak** mengubah keduanya, hanya menambah master data role,
permission, dan menu baru.

### Permission baru (tabel `permissions`)
Mengikuti pola `modul.aksi` yang sudah Anda pakai (`users.view`, dst), ditambahkan:
`events.*`, `event-categories.*`, `event-tickets.*`, `event-staffs.manage`,
`orders.*`, `payments.view`, `refunds.*`, `attendees.view`, `checkins.*`, `reports.*`.

### Menu sidebar baru (tabel `menus`)
- **Event Management** → Kategori Event, Daftar Event, Verifikasi Event, Jenis Tiket, Staff Event
- **Transaksi** → Daftar Pesanan, Pembayaran, Refund
- **Check-in** → Scan Tiket, Daftar Peserta
- **Laporan Tiket**

Semua menu baru otomatis di-assign ke role `SuperAdmin`. Untuk role lain (Event Manager,
Finance Event, Check-in Officer), assign menu sesuai kebutuhan lewat halaman `/roles`
yang sudah ada (tambahkan baris ke `menu_role`).

### `event_roles` vs `roles` — kenapa dipisah?
- `roles` (global) → mengatur **akses panel admin** (menu mana yang terlihat, CRUD apa
  yang boleh dilakukan). Satu user = satu role global.
- `event_roles` + `event_staffs` → mengatur **peran operasional per-event**. Satu user
  bisa jadi *Event Manager* di Event A tapi *Check-in Officer* di Event B. Tabel ini
  yang dipakai untuk menentukan siapa boleh approve refund event tertentu, siapa boleh
  scan tiket event tertentu, dst — di luar role global mereka.

## Catatan implementasi alur

- **Pembuatan Event**: insert ke `events` dengan `status = 'draft'`, lalu setelah
  `SUBMIT EVENT` ubah ke `status = 'pending'`.
- **Verifikasi Event** (Admin): permission `events.approve`. Jika disetujui →
  `status = 'published'`, jika ditolak → `status = 'rejected'` (kembali ke organizer).
- **Pembelian Tiket**: `orders` dibuat dengan `status = 'pending'`, `payment_status = 'unpaid'`.
  Setelah pilih metode pembayaran, insert ke `payments` (`status = 'pending'`).
  Saat callback gateway sukses → update `payments.status = 'success'`,
  `orders.payment_status = 'paid'`, `orders.status = 'paid'`, generate `attendees`
  dengan `ticket_code` + `qr_code`, kirim e-ticket.
- **Check-in Event**: scan `qr_code` → cari di `attendees`, jika `status = 'unused'`
  → insert/update `checkins` (`officer_id` dari user login, `checkin_at = now()`),
  ubah `attendees.status = 'used'`. Jika sudah `used`/`expired` → tampilkan pesan
  "Tidak Valid" sesuai alur.
- **Laporan & Monitoring**: query agregasi dari `orders`, `payments`, `attendees`,
  `checkins` per `event_id` — gunakan permission `reports.view` / `reports.export`.
