## Gambaran Umum Proyek

Renesca Aquatic adalah platform e-commerce komprehensif yang dirancang untuk toko online modern. Sistem ini menyediakan pengalaman belanja yang mulus bagi pelanggan dan alat manajemen yang kuat bagi admin. Dibangun di atas fondasi Laravel, dengan antarmuka dinamis menggunakan Livewire, Renesca Aquatic menawarkan skalabilitas, keamanan, dan kemudahan penggunaan.

## Fitur Utama

### Untuk Pelanggan:
*   **Katalog Produk yang Luas:** Jelajahi berbagai macam produk dengan detail lengkap, gambar, dan ulasan.
*   **Keranjang Belanja Interaktif:** Tambahkan, hapus, dan kelola item di keranjang belanja dengan pembaruan real-time.
*   **Proses Checkout yang Aman:** Checkout yang mudah dan aman dengan berbagai pilihan metode pembayaran.
*   **Pelacakan Pesanan:** Lacak status pesanan dari pembelian hingga pengiriman.
*   **Pengembalian Barang:** Ajukan permintaan pengembalian dengan mudah dan lacak statusnya.
*   **Ulasan Produk:** Berikan ulasan dan penilaian untuk produk yang dibeli.
*   **Autentikasi Pengguna:** Pendaftaran, login, dan manajemen profil yang aman.

### Untuk Admin:
*   **Dasbor Administratif:** Gambaran umum kinerja toko, pesanan, dan pengguna.
*   **Manajemen Produk Komprehensif:** Tambah, edit, hapus produk; kelola kategori, merek, dan vendor.
*   **Manajemen Pesanan:** Lihat, perbarui status pesanan, dan kelola pengembalian.
*   **Manajemen Pengguna:** Kelola akun pelanggan dan vendor.
*   **Manajemen Ulasan:** Moderasi ulasan produk.
*   **Manajemen Metode Pembayaran & Pengiriman:** Konfigurasi metode pembayaran dan pengiriman yang berbeda.
*   **Laporan & Analisis:** Dapatkan wawasan tentang penjualan dan tren.
*   **Trash Bin:** Fitur untuk mengelola item yang dihapus sementara sebelum penghapusan permanen.
*   **Manajemen Produk:** Vendor dapat mengelola produk mereka sendiri (menambah, mengedit, menghapus).
*   **Manajemen Pesanan Vendor:** Lihat dan kelola pesanan yang terkait dengan produk mereka.

## Teknologi yang Digunakan

*   **Backend Framework:** Laravel 10 (PHP)
*   **Frontend Framework:** Livewire 3
*   **Styling:** Tailwind CSS
*   **Database:** MySQL
*   **Autentikasi:** Laravel Fortify & Jetstream
*   **Server:** Laragon
*   **Package Manager (PHP):** Composer
*   **Package Manager (JS):** npm/Yarn


## Struktur Proyek

```
.
├── app/                  # Logika aplikasi, model, kontroler, Livewire components
│   ├── Actions/          # Aksi terkait Fortify dan Jetstream
│   ├── Http/             # Kontroler, Middleware, Responses
│   ├── Livewire/         # Komponen Livewire (Admin & Customer)
│   ├── Models/           # Model Eloquent
│   ├── Providers/        # Service providers
│   └── Rules/            # Custom validation rules
├── bootstrap/            # Bootstrapping framework
├── config/               # File konfigurasi
├── database/             # Migrasi, seeder, factory
├── public/               # File yang dapat diakses publik
├── resources/            # Aset frontend (CSS, JS) dan view Blade
├── routes/               # Definisi rute web, api, console
├── storage/              # Penyimpanan file, cache, logs
├── tests/                # Unit dan Feature tests
└── vendor/               # Dependensi Composer
```
