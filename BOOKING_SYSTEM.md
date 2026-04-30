# 📚 Dokumentasi Sistem Booking Buku

## Fitur yang Telah Dibuat

### 1. **Model & Database**
- ✅ Migration: `2026_04_29_000000_create_bookings_table.php`
- ✅ Model: `app/Models/Booking.php`
- Struktur tabel booking:
  - `id`, `siswa_id`, `book_id`, `status`, `keterangan`, `tanggal_booking`, `tanggal_disetujui`

### 2. **Controller: BookingController**
Lokasi: `app/Http/Controllers/BookingController.php`

**Method untuk Siswa:**
- `index()` - Tampilkan daftar booking siswa
- `create()` - Tampilkan form booking (hanya buku dengan stok > 0)
- `store()` - Simpan booking baru (dengan validasi stok)

**Method untuk Admin:**
- `adminIndex()` - Tampilkan semua booking
- `approve()` - Setujui booking & kurangi stok
- `reject()` - Tolak booking dengan keterangan
- `complete()` - Tandai booking selesai

### 3. **Validasi Stok**
```php
// Di method store() - Cegah booking jika stok kosong
if ($book->stok_tersedia <= 0) {
    return back()->with('error', 'Stok buku tidak tersedia!');
}

// Di method approve() - Cek stok lagi sebelum approve
if ($booking->book->stok_tersedia <= 0) {
    return back()->with('error', 'Stok buku tidak tersedia lagi!');
}
```

### 4. **Views**

#### Untuk Siswa:
- `resources/views/bookings/create.blade.php`
  - Grid buku dengan stok > 0
  - Modal konfirmasi booking
  - Tombol disabled jika stok habis

- `resources/views/bookings/index.blade.php`
  - Daftar booking dengan status (pending, approved, rejected, completed)
  - Stats card untuk total booking
  - Tampil keterangan jika ditolak

#### Untuk Admin:
- `resources/views/admin/bookings/index.blade.php`
  - Tabel booking dengan data siswa & buku
  - Tombol approve/reject/complete
  - Modal untuk input alasan penolakan
  - Stats untuk booking pending

### 5. **Routes**

**Siswa:**
```
GET    /booking              → bookings.index (daftar booking)
GET    /booking/buat         → bookings.create (form booking)
POST   /booking              → bookings.store (simpan booking)
```

**Admin:**
```
GET    /admin/booking        → admin.booking.index (manage booking)
PATCH  /admin/booking/{booking}/approve  → admin.booking.approve
PATCH  /admin/booking/{booking}/reject   → admin.booking.reject
PATCH  /admin/booking/{booking}/complete → admin.booking.complete
```

### 6. **Model Relationships**
- `Siswa` → `hasMany(Booking)`
- `Book` → `hasMany(Booking)`
- `Booking` → `belongsTo(Siswa)` & `belongsTo(Book)`

### 7. **Navigation Updates**
- ✅ Dashboard Siswa: Tambah tombol "Booking Buku" & "Booking Saya"
- ✅ Dashboard Admin: Tambah tab "Booking Buku"

## Status Booking
- **pending** - Menunggu persetujuan admin
- **approved** - Sudah disetujui, siswa bisa ambil buku
- **rejected** - Ditolak dengan alasan
- **completed** - Selesai (siswa sudah ambil buku)

## Flow Sistem

### Alur Siswa:
1. Siswa login → Dashboard
2. Klik "Booking Buku" → Lihat buku dengan stok > 0
3. Klik "Booking" pada buku → Konfirmasi → Submit
4. Status akan "Menunggu" sampai admin approve
5. Klik "Booking Saya" untuk tracking

### Alur Admin:
1. Admin login → Dashboard → Tab "Booking Buku"
2. Lihat daftar booking status "Menunggu"
3. Klik "Setujui" → Booking approved + stok berkurang
4. Atau klik "Tolak" → Input alasan → Booking ditolak
5. Jika approved, klik "Selesai" ketika siswa ambil buku

## Setup/Migration

Jalankan di terminal:
```bash
php artisan migrate
```

Ini akan membuat tabel `bookings` dengan fields yang sudah didefinisikan.

## Testing Flow

1. Login sebagai siswa
2. Cek stok buku di halaman books
3. Booking buku yang tersedia
4. Login sebagai admin
5. Lihat booking di dashboard
6. Approve/reject booking
7. Verifikasi stok berkurang setelah approve

---
**Status**: ✅ Siap untuk migration dan testing
