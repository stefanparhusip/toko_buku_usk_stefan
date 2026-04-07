# 3bieStore App

Aplikasi web 3bieStore berbasis Laravel 10 untuk manajemen buku, belanja user, cart, checkout, dan monitoring admin.

## Deskripsi Aplikasi
3bieStore App adalah aplikasi toko buku online sederhana dengan dua role utama:
- Admin: mengelola kategori, buku, dan monitoring order.
- User: melihat buku, mencari buku, menambahkan ke cart, checkout, dan melihat riwayat order.

## Fitur Utama
- Authentication (Register, Login, Logout) dengan Laravel Breeze.
- Role-based access (`admin` dan `user`).
- Admin panel:
  - CRUD Category
  - CRUD Book + upload image
  - Dashboard monitoring
  - Monitoring orders
- User panel:
  - View daftar buku + detail buku
  - Search buku (judul/kategori)
  - Cart (add, update quantity, delete)
  - Checkout (COD)
  - Riwayat order
- Validasi form dan flash message success/error.

## Tech Stack
- Laravel 10
- PHP 8.3+
- MySQL
- Bootstrap 5

## Cara Install
1. Clone repository
```bash
git clone <url-repository-anda>
cd 3biestore-app
```

2. Install dependency PHP
```bash
composer install
```

3. Install dependency frontend
```bash
npm install --legacy-peer-deps
npm run build
```

4. Salin file environment
```bash
cp .env.example .env
```
Untuk Windows PowerShell bisa pakai:
```powershell
Copy-Item .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Setup database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=USK_Stefan
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migration dan seeder
```bash
php artisan migrate:fresh --seed
```

8. Buat symbolic link storage
```bash
php artisan storage:link
```

9. Jalankan aplikasi
```bash
php artisan serve
```
Akses di browser: `http://127.0.0.1:8000`

## Testing
Jalankan semua test:
```bash
php artisan test
```

## Catatan Upload GitHub
- Pastikan file/folder berikut tidak diupload:
  - `vendor/`
  - `.env`
  - `node_modules/`
- Project ini sudah menggunakan `.gitignore` Laravel yang sesuai.

## Akun Admin Seeder
- Email: `admin@gmail.com`
- Password: `admin123`

## License
Project ini dibuat untuk kebutuhan pembelajaran/tugas akhir 3bieStore.
