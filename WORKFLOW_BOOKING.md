# 📚 Workflow Booking Buku - Library System

## Overview
Sistem ini menggunakan workflow **Booking → Approval → Peminjaman** untuk manajemen peminjaman buku yang lebih terstruktur.

---

## 🔄 Complete Workflow

### Step 1: Siswa Membuat Booking
**Lokasi:** `/books/{id}` (halaman detail buku)
**Action:** Klik tombol "📚 Pinjam Buku"

```
→ Modal "Booking Buku" terbuka
→ Siswa memilih durasi peminjaman (3, 7, 14, 21 hari, atau custom 1-30 hari)
→ Klik "Booking Sekarang"
```

**Route yang Digunakan:**
```
POST /buku/{book}/pinjam → BookingController::quickBook()
```

**Validasi di Backend:**
- ✅ Stok buku tersedia (stok_tersedia > 0)
- ✅ Siswa belum punya booking pending/approved untuk buku yang sama
- ✅ Durasi valid (1-30 hari)

**Database Change:**
```sql
INSERT INTO bookings (siswa_id, book_id, durasi, status, tanggal_booking, created_at, updated_at)
VALUES (:siswa_id, :book_id, :durasi, 'pending', NOW(), NOW(), NOW())
```

**User Feedback:** 
- ✅ Flash message: "Booking buku '{judul}' berhasil! Menunggu persetujuan admin."
- ✅ Redirect ke `/booking` (halaman daftar booking siswa)

---

### Step 2: Siswa Melihat Status Booking
**Lokasi:** `/booking` (dashboard booking siswa)

**Tampilan:**
1. **Stats Cards:**
   - Total Booking
   - Menunggu Persetujuan (amber)
   - Disetujui (blue)
   - Selesai (green)

2. **Tabel Booking - Kolom:**
   - Judul Buku
   - Pengarang
   - Tanggal Booking
   - Durasi Diminta
   - Status (⏳ Menunggu Persetujuan)
   - Tenggat Kembali: "Menunggu konfirmasi" (belum ada due date)

---

### Step 3: Admin Melihat Booking Tertunda
**Lokasi:** `/admin/booking` (dashboard admin booking)

**Tampilan:**
- Stats: Total Booking, Menunggu Persetujuan
- Tabel Booking dengan aksi untuk setiap booking pending:
  - **Tombol "Setujui"** → buka modal untuk approve
  - **Tombol "Tolak"** → buka modal untuk reject

**Modal Setujui Booking:**
```
Judul Buku: [nama buku]
Siswa: [nama siswa]
Durasi Yang Diminta: X hari
─────────────────────────
Durasi Persetujuan (dapat diubah):
  [3] [7] [14] [21] atau custom input 1-30
─────────────────────────
[Batal] [Setujui]
```

---

### Step 4: Admin Approve Booking
**Action:** Klik "Setujui" dan inputkan durasi persetujuan

**Route yang Digunakan:**
```
PATCH /admin/booking/{booking}/approve → BookingController::approve()
```

**Validasi:**
- ✅ Stok masih tersedia
- ✅ Durasi valid (1-30 hari)

**Database Changes:**
```sql
-- 1. Update booking record
UPDATE bookings 
SET status = 'approved', 
    durasi = :durasi_admin,
    tanggal_disetujui = NOW(),
    tanggal_rencana_kembali = DATE_ADD(NOW(), INTERVAL :durasi_admin DAY),
    updated_at = NOW()
WHERE id = :booking_id

-- 2. Kurangi stok buku
UPDATE books
SET stok_tersedia = stok_tersedia - 1
WHERE id = :book_id

-- 3. CREATE Peminjaman record (NEW!)
INSERT INTO peminjaman (siswa_id, buku_id, tanggal_pinjam, tanggal_kembali_rencana, status, created_at, updated_at)
VALUES (:siswa_id, :book_id, NOW(), DATE_ADD(NOW(), INTERVAL :durasi_admin DAY), 'dipinjam', NOW(), NOW())
```

**Key Point:** 
- Due date dihitung dari tanggal approval, bukan tanggal booking
- Formula: `tanggal_rencana_kembali = NOW() + durasi_admin days`

**User Feedback:**
- ✅ Flash message: "Booking disetujui! Tenggat kembali: [tanggal]"
- ✅ Reload halaman admin booking, booking sudah tidak di list pending

---

### Step 5: Siswa Melihat Booking Disetujui
**Lokasi:** `/dashboard` atau `/booking` (dashboard siswa)

**Tampilan - Section "Booking Disetujui":**
```
┌─────────────────────────────────────────────────┐
│ 📖 [Judul Buku]                                 │
│ Pengarang: [Nama Pengarang]                     │
│ Disetujui Tanggal: [tanggal_disetujui]          │
│ Batas Kembali: [tanggal_rencana_kembali]        │
│ Sisa Hari: X hari atau TERLAMBAT! (if negative)│
└─────────────────────────────────────────────────┘
```

**Kalkulasi Sisa Hari:**
```php
$sisa_hari = now()->diffInDays($booking->tanggal_rencana_kembali)
// Positif = belum terlambat
// Negatif = terlambat X hari
```

---

### Step 6: Status di Dashboard Siswa

Dashboard siswa menampilkan 3 section terpisah:

#### Section 1: Buku Aktif Dipinjam (PEMINJAMAN)
```
Tampilkan: peminjaman dengan status 'dipinjam' atau 'terlambat'
Dari table: peminjaman (tidak dari bookings)
```

#### Section 2: Booking Menunggu Persetujuan (BOOKING)
```
Status: ⏳ Menunggu Admin
Durasi: X hari (yang diminta)
Pesan: "Tenggat kembali akan ditentukan setelah disetujui"
Dari table: bookings WHERE status = 'pending'
```

#### Section 3: Booking Disetujui (BOOKING)
```
Status: ✅ Disetujui
Batas Kembali: [tanggal_rencana_kembali]
Sisa Hari: X hari atau TERLAMBAT! (red)
Dari table: bookings WHERE status = 'approved'
```

---

## 📊 Database Schema

### Table: bookings
```
id                    BIGINT PRIMARY KEY
siswa_id             BIGINT FK → siswa.id
book_id              BIGINT FK → books.id
status               ENUM('pending', 'approved', 'rejected', 'completed')
durasi               INT (hari, nullable)
keterangan           TEXT (alasan jika ditolak)
tanggal_booking      TIMESTAMP (waktu booking dibuat)
tanggal_disetujui    TIMESTAMP (waktu disetujui admin, nullable)
tanggal_rencana_kembali TIMESTAMP (calculated due date, nullable)
tanggal_kembali_aktual  TIMESTAMP (actual return date, nullable)
created_at, updated_at TIMESTAMP
```

### Table: peminjaman
```
id                      BIGINT PRIMARY KEY
siswa_id               BIGINT FK → siswa.id
buku_id                BIGINT FK → books.id
tanggal_pinjam         TIMESTAMP (actual borrow date = tanggal_disetujui booking)
tanggal_kembali_rencana TIMESTAMP (due date)
tanggal_kembali_aktual TIMESTAMP (actual return)
status                 ENUM('dipinjam', 'terlambat', 'dikembalikan')
created_at, updated_at TIMESTAMP
```

---

## 🔑 Key Points

1. **Booking ≠ Peminjaman**
   - Booking = Request untuk pinjam (waiting approval)
   - Peminjaman = Actual borrow (after approval)

2. **Stok Berkurang Saat Approval**
   - Tidak saat booking (user bisa cancel booking)
   - Saat admin approve (komitmen untuk pinjam)

3. **Due Date dari Approval**
   - Bukan dari booking date
   - Formula: approval_date + durasi_admin_days

4. **Workflow Order**
   ```
   Booking (pending)
        ↓
   Admin Review & Approve
        ↓
   Booking Status → approved + Create Peminjaman
        ↓
   Student dapat buku
   ```

---

## 🧪 Testing Checklist

- [ ] Siswa bisa membuat booking dari halaman buku
- [ ] Booking tersimpan dengan status 'pending'
- [ ] Siswa melihat booking di "Booking Menunggu Persetujuan"
- [ ] Admin melihat booking pending di admin panel
- [ ] Admin bisa approve dengan durasi custom
- [ ] Stok berkurang setelah approval
- [ ] Peminjaman record tercipta saat approval
- [ ] Booking berubah ke "Booking Disetujui" di dashboard siswa
- [ ] Sisa hari dihitung dengan benar
- [ ] Late penalty sistem bekerja (TERLAMBAT! status)
- [ ] Admin bisa reject booking dengan keterangan
- [ ] Rejected booking tetap terlihat dengan alasan penolakan

---

## 🚀 Routes Reference

**Siswa Routes (middleware: auth):**
```
GET    /booking                    → BookingController@index (daftar booking siswa)
GET    /booking/buat              → BookingController@create (form booking)
POST   /booking                    → BookingController@store (simpan booking form)
POST   /buku/{book}/pinjam        → BookingController@quickBook (booking dari detail)
```

**Admin Routes (middleware: auth, admin):**
```
GET    /admin/booking                           → BookingController@adminIndex
PATCH  /admin/booking/{booking}/approve        → BookingController@approve
PATCH  /admin/booking/{booking}/reject         → BookingController@reject
PATCH  /admin/booking/{booking}/complete       → BookingController@complete
```

---

## 🐛 Troubleshooting

### Issue: "Stok tidak tersedia"
- Cek `books.stok_tersedia > 0`
- Pastikan tidak ada booking approved yang belum dikembalikan

### Issue: Peminjaman tidak tercreate
- Pastikan `Peminjaman` model terimport di `BookingController`
- Cek bahwa approve method benar-benar execute `Peminjaman::create()`

### Issue: Due date tidak akurat
- Due date dihitung dari `tanggal_disetujui`, bukan `tanggal_booking`
- Carbon `addDays()` harus langsung pada sekarang (tidak cache)

