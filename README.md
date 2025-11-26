# Perpus – Sistem Manajemen Peminjaman Buku

Aplikasi web berbasis Laravel 12 untuk mengelola perpustakaan kampus: katalog buku, data anggota, peminjaman/pengembalian, dan manajemen pengguna admin maupun user biasa.

---

## Tumpukan Teknologi

- PHP 8.2+, Laravel 12, Eloquent ORM
- MySQL / MariaDB (atau database lain yang didukung Laravel)
- Vite + Bootstrap 5 untuk aset front-end
- Composer & NPM sebagai dependency manager

---

## Fitur Utama

**Publik**
- Halaman landing dengan daftar buku terbaru.
- Pencarian dan penelusuran katalog tanpa login.

**User (role: `user`, NIM diawali `U.`)**
- Dashboard pengguna berisi buku-buku yang tersedia.
- Peminjaman buku mandiri: buku dipilih dari katalog, anggota otomatis mengikuti NIM login.
- Melihat daftar peminjaman yang masih aktif dan mengembalikan buku.
- Manajemen profil dan ubah kata sandi.

**Admin (role: `admin`, NIM diawali `A.`)**
- Dashboard administrasi dengan akses cepat ke modul inti.
- CRUD buku lengkap (tambah, ubah, hapus, update stok).
- CRUD data anggota (`mst_anggota`).
- CRUD peminjaman (override data pinjam).
- Manajemen akun user (buat, edit role, hapus).
- Pengelolaan profil admin + ubah password.

---

## Prasyarat

- PHP 8.2 atau lebih baru dengan ekstensi `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`.
- Composer 2.x.
- Node.js 18+ dan NPM 9+ (untuk build aset).
- MySQL/MariaDB lokal atau server database lain.
- Git (opsional tapi disarankan).

---

## Langkah Instalasi

1. **Clone & masuk ke folder proyek**
   ```bash
   git clone https://github.com/your-org/perpus.git
   cd perpus
   ```

2. **Install dependency backend & frontend**
   ```bash
   composer install
   npm install
   ```

3. **Siapkan berkas environment**
   ```bash
   cp .env.example .env
   ```
   Lalu sesuaikan nilai berikut pada `.env`:
   ```
   APP_NAME="Perpus"
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=perpus
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Siapkan database**
   - Opsi A (bersih): jalankan migrasi standar.
     ```bash
     php artisan migrate
     ```
   - Opsi B (memakai data contoh): impor `perpus.sql` ke database Anda (`mysql -u root -p perpus < perpus.sql`). File tersebut berisi akun admin/user contoh, data buku, anggota, dan peminjaman.

6. **Build aset front-end (opsional untuk mode dev)**
   ```bash
   npm run dev
   ```
   Untuk produksi gunakan `npm run build`.

---

## Menjalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://127.0.0.1:8000`. Saat pengembangan, jalankan juga watcher Vite:

```bash
npm run dev
```

---

## Alur Login & Register

### Registrasi akun baru
1. Buka `http://localhost:8000/register`.
2. Isi:
   - **Nama lengkap**.
   - **NIM** dengan format `A.xxx.xx.xxxx` untuk admin atau `U.xxx.xx.xxxx` untuk user biasa.
   - **Program Studi** wajib diisi jika NIM diawali `U.` (otomatis membuat data anggota).
   - **Email** aktif.
   - **Opsi password**: pilih auto-generate (password ditampilkan setelah berhasil daftar) atau set manual minimal 8 karakter.
3. Submit formulir. Role akan ditentukan otomatis dari prefix NIM.

### Login
1. Buka `http://localhost:8000/login`.
2. Masukkan NIM *atau* email pada kolom identifier.
3. Masukkan password, lalu tekan **Masuk**.
4. Sistem mendeteksi role:
   - Admin diarahkan ke `Admin Dashboard`.
   - User diarahkan ke `User Dashboard`.

### Akun contoh (jika impor `perpus.sql`)

|Nim, Email,& Password login untuk pengujian Admin dan user      |
------------------------------------------------------------------
| Role  | NIM             |        Email             | Password  |
|-------|-----------------|--------------------------|-----------|
| Admin | A.111.11.1111   | officialadmin@gmail.com  | 12345678  |
| User  | U.111.11.1111   | officialuser@gmail.com   | 12345678  |

Nim dan Email untuk pengujian Admin : A.111.11.1111 , officialadmin@gmail.com , password : 12345678 
Nim dan Email untuk pengujian User  : U.111.11.1111 , officialuser@gmail.com , password : 12345678

\*Password diset ke `password` pada dump contoh. Ubah segera di menu profil setelah login.

---

## Tips Penggunaan

- **Stok Buku** otomatis berkurang saat user melakukan peminjaman mandiri, dan bertambah ketika admin/user mengembalikan buku.
- **Peminjaman User**: field anggota dikunci ke data anggota milik user yang sedang login (berdasarkan NIM) sehingga tidak bisa meminjam atas nama orang lain.
- **Profil & Password** tersedia untuk admin maupun user di menu masing-masing.
- **Rate limiting login**: maksimal 5 percobaan per menit, sesuai middleware `throttle:5,1`.

---

## Skrip Berguna

- `composer test` – menjalankan seluruh PHPUnit tests.
- `npm run build` – build aset produksi.
- `composer run dev` – jalankan stack dev lengkap (artisan serve, queue listener, log streamer, Vite).

---

## Troubleshooting Ringan

- **Tidak bisa konek DB**: pastikan `.env` sesuai, database sudah dibuat, dan jalankan `php artisan config:clear`.
- **Aset tidak termuat**: jalankan `npm run dev` atau `npm run build`, lalu reload.
- **Password lupa**: buat akun baru atau reset langsung melalui database (update kolom `password` dengan `bcrypt('password-baru')`).

## Checking Function In Website Using Inspect
 - **Press F12 Select Console Scroll to bottom.
