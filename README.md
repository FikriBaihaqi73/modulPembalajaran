# PembelajaranApp: Platform Modul Interaktif untuk Santri dan Mentor


## Tentang Aplikasi

PembelajaranApp adalah platform edukasi interaktif yang dirancang untuk memfasilitasi manajemen dan akses modul pembelajaran bagi santri dan mentor. Aplikasi ini memungkinkan mentor untuk membuat dan mengelola modul pembelajaran sesuai dengan jurusan mereka, sementara santri dapat dengan mudah menjelajahi, membaca, dan mengunduh modul untuk akses offline. Admin memiliki visibilitas penuh atas seluruh aktivitas dan data di platform.

## Fitur Utama

### Untuk Santri:
-   **Jelajahi Modul:** Akses daftar modul pembelajaran yang komprehensif.
-   **Filter Modul:** Saring modul berdasarkan kategori dan, jika admin login, berdasarkan jurusan.
-   **Akses Offline:** Unduh modul dalam format PDF atau kategori modul dalam format ZIP untuk dibaca kapan saja, di mana saja.
-   **Profil Pengguna:** Kelola detail profil pribadi dan kata sandi.

### Untuk Mentor:
-   **Manajemen Modul:** Buat, edit, lihat, dan kelola modul pembelajaran yang terkait dengan jurusan spesifik mentor.
-   **Manajemen Kategori Modul:** Atur kategori untuk modul mereka.
-   **Manajemen Santri:** Kelola data santri yang terkait dengan jurusan mereka.
-   **Pengunggahan Konten Kaya:** Gunakan editor Tiptap dengan kemampuan pengunggahan gambar dan pratinjau video YouTube yang dapat diubah ukurannya.
-   **Kontrol Visibilitas Modul:** Tentukan apakah modul terlihat oleh santri atau tidak.

### Untuk Admin:
-   **Dasbor Komprehensif:** Lihat ringkasan total santri, total mentor, dan jumlah modul per jurusan.
-   **Manajemen Santri:** Lihat dan kelola data santri.
-   **Manajemen Mentor:** Lihat dan kelola data mentor.
-   **Pemantauan Modul:** Lihat semua modul dari berbagai jurusan dengan opsi filter.

## Teknologi yang Digunakan

-   **Backend:** Laravel (PHP Framework)
-   **Frontend:** Blade (Templating Engine), JavaScript (dengan React untuk editor Tiptap)
-   **Database:** MySQL (atau database relasional lainnya yang didukung Laravel)
-   **Editor Konten:** Tiptap
-   **Ikon:** Font Awesome
-   **Styling:** Tailwind CSS
-   **Penyimpanan Media:** Cloudinary (untuk thumbnail modul)

## Instalasi dan Setup

Untuk menjalankan aplikasi ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone Repository:**
    ```bash
    git clone <URL_REPOSITORY_ANDA>
    cd PembelajaranApp
    ```

2.  **Instal Dependensi Composer:**
    ```bash
    composer install
    ```

3.  **Instal Dependensi Node.js:**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment (.env):**
    -   Salin file `.env.example` ke `.env`:
        ```bash
        cp .env.example .env
        ```
    -   Generate kunci aplikasi:
        ```bash
        php artisan key:generate
        ```
    -   Konfigurasi detail database Anda di file `.env`.
    -   Tambahkan kredensial Cloudinary Anda di file `.env` untuk pengunggahan thumbnail modul (jika digunakan).

5.  **Jalankan Migrasi Database dan Seeder:**
    ```bash
    php artisan migrate:fresh --seed
    ```
    Ini akan membuat tabel database dan mengisi data awal (termasuk peran pengguna dan jurusan).

6.  **Kompilasi Aset Frontend:**
    ```bash
    npm run dev
    ```
    Atau untuk produksi:
    ```bash
    npm run build
    ```

7.  **Jalankan Server Lokal:**
    ```bash
    php artisan serve
    ```

8.  **Akses Aplikasi:**
    Buka browser Anda dan kunjungi `http://127.0.0.1:8000` (atau alamat yang ditampilkan oleh `php artisan serve`).

## Kontribusi

Kami menyambut kontribusi! Jika Anda ingin berkontribusi, silakan fork repository dan buat pull request dengan fitur atau perbaikan Anda. Pastikan untuk mengikuti pedoman kontribusi yang ada.

## Lisensi

Aplikasi ini dilisensikan di bawah Lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.
