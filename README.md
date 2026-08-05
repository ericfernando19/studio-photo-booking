# Studio Foto Booking

Sistem manajemen booking studio foto berbasis web dengan Laravel. Memudahkan admin mengelola pemesanan, pembayaran, antrian, dan laporan dalam satu platform.

## Fitur

### Customer
- Booking online dengan pilihan paket
- Upload bukti transfer DP
- Melihat status booking

### Admin
- **Dashboard** - Ringkasan booking dan pendapatan
- **Kalender** - Visualisasi booking per hari/minggu/bulan
- **Booking** - Kelola data booking dengan filter tanggal & status
- **Pembayaran** - Verifikasi DP & proses pelunasan
- **Antrian** - Sistem antrian per studio dengan panggilan otomatis
- **Customer** - Riwayat booking per customer
- **Laporan** - Export laporan booking, pendapatan, paket, & customer (PDF/Excel)

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3
- **Database:** MySQL
- **Frontend:** Blade, Bootstrap 5, FullCalendar
- **PDF:** DomPDF
- **Excel:** Maatwebsite Excel

## Instalasi

```bash
# Clone repo
git clone https://github.com/username/studio-photo-booking.git
cd studio-photo-booking

# Install dependencies
composer install

# Copy environment
cp .env.example .env

# Generate key
php artisan key:generate

# Database
php artisan migrate

# Seed admin
php artisan db:seed

# Run
php artisan serve
```

Login default:
- Email: `admin@admin.com`
- Password: `password`

## License

MIT
