# Tugas 10 — Dashboard & RBAC

Implementasi tambahan pada proyek portal akademik:

- Backoffice memakai `@extends('adminlte::page')` (AdminLTE v4).
- Autentikasi tetap memakai alur Laravel Breeze yang sudah ada.
- Spatie Laravel Permission menyimpan role dan permission di database.
- Role `Admin` dapat melihat seluruh project dan menghapus project.
- Role `Staf` hanya dapat melihat project miliknya dan tidak memiliki tombol/akses hapus.
- Dashboard menampilkan tiga statistik berbasis `count()`: total project sesuai cakupan role, total user, dan project hari ini.
- Pencarian menggunakan `when()` dan pagination menggunakan `withQueryString()`.
- Seeder membuat akun demo dan data project Faker.
- Halaman login menyediakan tombol login instan Admin dan Staf.

## Instalasi

Pastikan PHP 8.3+, Composer, Node.js, dan database sudah tersedia. Di root proyek jalankan:

```bash
composer install
npm install
npm install bootstrap@^5.3 bootstrap-icons@^1.13 overlayscrollbars@^2.11 @fontsource/source-sans-3@^5.3
php artisan adminlte:install
php artisan vendor:publish --provider="Spatie\\Permission\\PermissionServiceProvider"
```

Atur koneksi database pada `.env`, lalu jalankan:

```bash
php artisan optimize:clear
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

> `migrate:fresh` menghapus seluruh tabel dan data database. Gunakan hanya pada database pengembangan/demo yang boleh di-reset. Untuk database yang berisi data penting, jalankan `php artisan migrate --seed`.

## Akun demo

| Role | Email | Password |
|---|---|---|
| Admin | `admin@pbkk.test` | `password` |
| Staf | `staf@pbkk.test` | `password` |

Semua akun demo di-seed dengan `email_verified_at` terisi. Pendaftaran baru otomatis mendapat role `Staf`.

## Skenario demo evaluasi

1. Login sebagai Admin, buka Dashboard dan Data Project. Admin melihat seluruh project dan tombol Hapus.
2. Hapus satu project untuk menunjukkan aksi admin.
3. Logout, login sebagai Staf. Staf hanya melihat project miliknya dan tidak melihat tombol Hapus.
4. Coba akses URL `DELETE /admin/projects/{id}` sebagai Staf melalui request langsung; server harus menolak dengan HTTP 403.
5. Cari judul/tema/pemilik di tabel, lalu pindah halaman. Kata kunci tetap ada karena `withQueryString()`.
