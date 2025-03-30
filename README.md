# Quick POS

Quick POS adalah aplikasi Point of Sale (POS) berbasis web yang dikembangkan menggunakan framework Laravel. Aplikasi ini dirancang untuk membantu manajemen restoran atau kafe dalam mengelola pesanan, pembayaran, dan aktivitas operasional lainnya.

## Fitur Utama

### 1. Manajemen Menu
- Mengelola katalog produk (makanan dan minuman)
- Mengkategorikan produk untuk navigasi yang lebih mudah
- Pengaturan ketersediaan produk (tersedia/tidak tersedia)
- Unggah gambar produk

### 2. Manajemen Meja
- Pengelolaan meja dengan kapasitas dan status (tersedia, terisi, direservasi)
- Pemberian QR Code unik untuk setiap meja
- Pelanggan dapat memindai QR Code untuk melihat menu dan memesan

### 3. Pemesanan
- Pemesanan langsung dari meja menggunakan smartphone (scan QR Code)
- Pemesanan dari kasir/staff
- Status pesanan real-time (menunggu, diproses, selesai, dibatalkan)
- Pantau status setiap item pesanan (menunggu, dipersiapkan, siap, diantarkan)
- Catatan khusus untuk setiap pesanan dan item pesanan

### 4. Pembayaran
- Dukungan berbagai metode pembayaran (tunai, debit, kredit, QRIS, dll)
- Cetak struk pembayaran
- Rekam jumlah uang diterima dan kembalian
- Pelacakan status pembayaran

### 5. Dashboard & Analitik
- Ringkasan penjualan harian
- Produk terlaris
- Status meja real-time
- Grafik penjualan mingguan dan bulanan
- Pemantauan kinerja berdasarkan kategori (makanan/minuman)
- Analisis metode pembayaran
- Nilai rata-rata pesanan
- Performa meja

### 6. Manajemen Pengguna
- Multi-role (Admin, Kasir, Staff, dll)
- Manajemen izin berdasarkan peran
- Profil pengguna dan pengaturan keamanan

## Teknologi

Quick POS dibangun menggunakan teknologi berikut:

- **Backend**: Laravel 10.x, PHP 8.1+
- **Database**: PostgreSQL
- **Frontend**: Blade Template, TailwindCSS, Alpine.js
- **Otentikasi**: Laravel's built-in authentication
- **QR Code**: Dikembangkan untuk akses menu digital
- **Dashboard**: Chart.js untuk visualisasi data

## Persyaratan Sistem

- PHP 8.1 atau yang lebih baru
- Composer
- PostgreSQL
- Node.js & NPM untuk aset frontend
- Web server (Apache/Nginx)

## Instalasi

Berikut adalah langkah-langkah untuk menginstal dan menjalankan aplikasi Quick POS di lingkungan lokal Anda:

1. Clone repositori:
```bash
git clone https://github.com/bagaspra16/quick-pos.git
cd quick-pos
```

2. Instal dependensi PHP:
```bash
composer install
```

3. Instal dependensi JavaScript:
```bash
npm install
```

4. Konfigurasi lingkungan:
   - Salin file `.env.example` menjadi `.env`
   - Sesuaikan pengaturan database dan aplikasi dalam file `.env`

5. Generate kunci aplikasi:
```bash
php artisan key:generate
```

6. Jalankan migrasi dan seeder:
```bash
php artisan migrate --seed
```

7. Link storage:
```bash
php artisan storage:link
```

8. Jalankan server:
```bash
php artisan serve
```

9. Akses aplikasi di browser: `http://localhost:8000`

## Penggunaan Dasar

### Login Administrator
- Username: admin@example.com
- Password: digitalquickpos123

### Langkah Dasar Pengoperasian
1. Buat kategori produk (Makanan, Minuman, etc)
2. Tambahkan produk ke dalam kategori
3. Buat dan atur meja dengan QR Code
4. Mulai terima pesanan dari meja atau kasir
5. Proses pembayaran

## Alur Kerja Aplikasi

1. **Pelanggan Datang**:
   - Staff menyambut dan mengarahkan ke meja
   - Pelanggan duduk dan scan QR Code di meja

2. **Pemesanan**:
   - Pelanggan melihat menu digital
   - Pelanggan memesan melalui smartphone
   - Pesanan masuk ke sistem

3. **Dapur & Bar**:
   - Staff dapur/bar melihat pesanan baru
   - Staff memproses dan memperbarui status

4. **Pengantaran**:
   - Pelayan mengantarkan pesanan ke meja
   - Status item pesanan diperbarui menjadi "diantarkan"

5. **Pembayaran**:
   - Pelanggan meminta tagihan
   - Kasir memproses pembayaran
   - Struk dicetak

## Pengembangan Lebih Lanjut

- Integrasi dengan printer termal
- Aplikasi mobile untuk staff
- Notifikasi real-time menggunakan WebSockets
- Sistem reservasi meja
- Laporan stok dan inventori
- Program loyalitas pelanggan

## Mengunggah ke GitHub

Untuk memasukkan project ini ke GitHub, ikuti langkah-langkah berikut:

1. **Buat Repository di GitHub**:
   - Login ke akun GitHub Anda
   - Buat repository baru dengan nama `quick-pos`
   - Jangan menginisialisasi repository dengan README, .gitignore, atau License

2. **Persiapkan Project untuk GitHub**:
   - Pastikan Anda sudah memiliki file `.gitignore` yang tepat untuk project Laravel. Jika belum, buat file baru dengan konten berikut:

   ```
   /node_modules
   /public/hot
   /public/storage
   /storage/*.key
   /vendor
   .env
   .env.backup
   .phpunit.result.cache
   docker-compose.override.yml
   Homestead.json
   Homestead.yaml
   npm-debug.log
   yarn-error.log
   /.idea
   /.vscode
   ```

3. **Persiapkan .env.example**:
   - Untuk menjaga keamanan informasi sensitif namun tetap memberikan template konfigurasi, konversi file `.env` menjadi `.env.example`:
   
   ```bash
   # Salin .env ke .env.example dan hapus nilai-nilai sensitif
   cat .env | grep -v "APP_KEY" | grep -v "DB_PASSWORD" | grep -v "MAIL_PASSWORD" | grep -v "REDIS_PASSWORD" | grep -v "AWS" | grep -v "PUSHER" > .env.example
   
   # Atau salin secara manual dan hapus/ganti nilai sensitif
   cp .env .env.example
   ```
   
   - Buka file `.env.example` dan ganti semua nilai sensitif dengan placeholder:
     - `APP_KEY=base64:your_application_key_here`
     - `DB_PASSWORD=your_database_password_here`
     - dan seterusnya
   
   - File `.env.example` ini akan menjadi template bagi pengguna lain yang mengkloning repository

4. **Inisialisasi Git dan Unggah ke GitHub**:
   - Buka terminal dan arahkan ke directory project
   - Jalankan perintah berikut satu per satu:

   ```bash
   # Inisialisasi Git repository lokal
   git init

   # Tambahkan semua file ke staging area
   git add .

   # Commit perubahan
   git commit -m "Initial commit"

   # Tambahkan remote repository
   git remote add origin https://github.com/username/quick-pos.git

   # Push ke repository GitHub
   git push -u origin main
   ```

   (Catatan: Jika branch utama Anda bernama `master`, gunakan `git push -u origin master`)

5. **Lindungi Informasi Sensitif**:
   - Pastikan file `.env` sudah masuk dalam `.gitignore`
   - Jangan pernah mengupload kredensial database atau API key ke GitHub
   - Selalu periksa commit Anda sebelum push untuk memastikan tidak ada informasi sensitif yang terekspos

6. **Verifikasi**:
   - Buka repository GitHub Anda untuk memastikan semua file telah terunggah dengan benar
   - Pastikan file sensitif seperti `.env` tidak terunggah, tetapi `.env.example` sudah ada

### Tips Tambahan untuk Kolaborasi

- Gunakan branch terpisah untuk fitur baru: `git checkout -b nama-fitur`
- Selalu pull perubahan terbaru sebelum mulai bekerja: `git pull origin main`
- Gunakan Issues dan Pull Requests GitHub untuk mengelola pekerjaan tim
- Pertimbangkan untuk menyiapkan GitHub Actions untuk CI/CD otomatis
