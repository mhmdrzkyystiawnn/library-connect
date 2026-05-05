# 🔄 Alur Lengkap User & Admin - Library Booking System

## 📋 Ringkasan
Sistem booking ini memiliki **2 alur utama**: 
1. **User/Siswa** - Membuat booking dan tracking status
2. **Admin** - Menerima, menyetujui/menolak, dan menyelesaikan booking

---

## 🚨 Important Notes & Fixes

### ✅ Fixed Issues:
- **Durasi Split**: Sekarang ada `durasi_diminta` (request siswa) dan `durasi_disetujui` (approval admin)
- **Tracking Fields**: Ditambah `tanggal_diambil`, `tanggal_dikembalikan`, `tanggal_deadline` untuk tracking lengkap
- **REJECTED Status**: Siswa BOLEH membuat booking ulang setelah di-reject (tidak blocking)
- **Route Clarification**: `quickBook()` vs `store()` sudah dijelaskan perbedaannya
- **Admin Notification**: Admin sekarang dapat notifikasi untuk actions mereka

---

## 👤 ALUR USER/SISWA

### 1️⃣ Login & Dashboard
```
AKSI: Siswa login ke sistem
RESULT: 
  - Masuk ke Dashboard Siswa
  - Melihat menu utama (Books, Booking Saya, Profile, dll)
```

### 2️⃣ Browsing Buku
```
AKSI: Klik menu "Booking Buku" atau "Lihat Buku"
RESULT: 
  - Tampil daftar buku dengan filter stok > 0
  - Hanya buku dengan stok tersedia yang bisa di-booking
  - Grid/tabel berisi: Judul, Pengarang, ISBN, Cover, stok, tombol Booking
```

### 3️⃣ Membuat Booking
```
AKSI: 
  1. Klik tombol "📚 Pinjam Buku" pada buku pilihan
  2. Modal booking terbuka
  3. Pilih durasi: 3 hari, 7 hari, 14 hari, 21 hari, atau custom (1-30 hari)
  4. Klik "Booking Sekarang"

VALIDASI DI BACKEND:
  ✅ Stok buku tersedia (stok_tersedia > 0)
  ✅ Siswa belum punya booking PENDING/APPROVED untuk buku yg sama (REJECTED/COMPLETED boleh)
  ✅ Durasi valid (1-30 hari)

ERROR HANDLING:
  ❌ Stok kosong → "Stok buku tidak tersedia!"
  ❌ Booking duplikat → "Sudah ada booking aktif untuk buku ini!"
  ❌ Durasi invalid → "Durasi harus 1-30 hari!"

DATABASE:
  INSERT INTO bookings (siswa_id, book_id, durasi_diminta, status, tanggal_booking)
  VALUES (siswa.id, book.id, durasi_hari, 'pending', NOW())
```

### 4️⃣ Notifikasi & Redirect
```
RESULT:
  - Flash Message: "✅ Booking buku '{Judul}' berhasil! Menunggu persetujuan admin"
  - Redirect ke: /booking (halaman "Booking Saya")
```

### 5️⃣ Monitor Status Booking
```
LOKASI: /booking (Halaman "Booking Saya")

TAMPILAN:
  📊 Stats Cards:
    - Total Booking: X
    - Menunggu Persetujuan (⏳): Y
    - Disetujui (✅): Z
    - Selesai (✔️): W

  📋 Tabel Booking:
    | Judul Buku | Pengarang | Tgl Booking | Durasi | Status | Aksi |
    
  Status Mungkin:
    ⏳ PENDING    → Menunggu persetujuan admin
    ✅ APPROVED   → Disetujui, bisa ambil buku
    ❌ REJECTED   → Ditolak (tampil alasan), bisa booking ulang
    ✔️ COMPLETED  → Sudah selesai
```

### 6️⃣ Booking Disetujui Admin
```
NOTIFIKASI: Siswa dapat notifikasi booking approved

INFORMASI YANG DITAMPILKAN:
  - Status berubah menjadi ✅ APPROVED
  - Durasi persetujuan (bisa berbeda dari yang diminta)
  - Tanggal deadline kembali buku
  - Pesan: "Booking disetujui! Silakan ambil buku di perpustakaan"

ACTION SISWA:
  - Ambil buku di perpustakaan sesuai durasi yang disetujui
```

### 7️⃣ Booking Ditolak Admin
```
NOTIFIKASI: Siswa dapat notifikasi booking rejected

INFORMASI YANG DITAMPILKAN:
  - Status berubah menjadi ❌ REJECTED
  - Alasan penolakan dari admin
  - Pesan: "Booking ditolak, alasan: [KETERANGAN]"

ACTION SISWA:
  - Bisa membuat booking ulang untuk buku yang sama
  - Alasan penolakan membantu siswa memahami masalahnya
```

### 8️⃣ Peminjaman Selesai
```
TRIGGER: Admin menandai booking sebagai COMPLETED

RESULT DI SISWA:
  - Status berubah menjadi ✔️ COMPLETED
  - Buku ditampilkan di riwayat peminjaman
  - Booking selesai, siswa bisa booking buku lagi
```

---

## 👨‍💼 ALUR ADMIN

### 1️⃣ Login & Dashboard Admin
```
AKSI: Admin login ke sistem
RESULT: 
  - Masuk ke Admin Dashboard
  - Melihat menu admin (Manage Books, Manage Bookings, Manage Siswa, dll)
```

### 2️⃣ Akses Halaman Booking
```
AKSI: Klik "Booking Buku" atau tab "Booking" di admin dashboard
RESULT: 
  - Tampil halaman /admin/booking
  - Menampilkan SEMUA booking dengan berbagai status
```

### 3️⃣ Dashboard Admin Booking
```
TAMPILAN:
  📊 Stats Cards:
    - Total Booking: X
    - Menunggu Persetujuan (⏳): Y (highlighted/urgent)
    - Disetujui (✅): Z
    - Selesai (✔️): W

  📋 Tabel Booking dengan kolom:
    | Siswa | Buku | Durasi | Tgl Booking | Status | Aksi |

  FITUR FILTER:
    - Filter by Status (Pending, Approved, Rejected, Completed)
    - Search by Nama Siswa/Judul Buku
    - Sort by Tanggal Booking
```

### 4️⃣ Cek Booking Pending
```
FOCUS: Booking dengan Status PENDING

INFORMASI BOOKING:
  - Nama Siswa: [NAMA]
  - Judul Buku: [JUDUL]
  - Pengarang: [PENGARANG]
  - Durasi Diminta: X hari
  - Tanggal Booking: [TANGGAL]
  - Stok Saat Ini: [JUMLAH]

OPSI AKSI:
  🟢 Tombol "Setujui" - Approve booking
  🔴 Tombol "Tolak" - Reject booking
```

### 5️⃣ Approve Booking
```
AKSI: Admin klik tombol "Setujui" pada booking pending

MODAL APPROVE TERBUKA:
  ┌─────────────────────────────────────┐
  │ SETUJUI BOOKING                     │
  ├─────────────────────────────────────┤
  │ Siswa: [NAMA]                       │
  │ Buku: [JUDUL]                       │
  │ Durasi Diminta: X hari              │
  ├─────────────────────────────────────┤
  │ Durasi Persetujuan: [3][7][14][21] │
  │ atau input custom: [  ] hari        │
  ├─────────────────────────────────────┤
  │ [Batal] [Setujui]                   │
  └─────────────────────────────────────┘

VALIDASI SEBELUM APPROVE:
  ✅ Stok buku masih tersedia (> 0)
  ✅ Durasi valid (1-30 hari)

ERROR HANDLING:
  ❌ Stok habis → "Stok buku telah habis! Approval dibatalkan"
  ❌ Durasi invalid → "Durasi harus 1-30 hari"

JIKA VALID - DATABASE UPDATE:
  UPDATE bookings SET 
    status = 'approved',
    durasi_disetujui = [durasi_persetujuan],
    tanggal_disetujui = NOW()
  WHERE id = booking.id

  UPDATE books SET 
    stok_tersedia = stok_tersedia - 1
  WHERE id = booking.book_id

  💡 NOTE: durasi_diminta TIDAK BERUBAH, hanya durasi_disetujui yang bisa berbeda

NOTIFIKASI:
  📧 Siswa mendapat notifikasi:
    "✅ Booking buku '{Judul}' disetujui!"
    "Durasi: {X} hari"
    "Tanggal Kembali: {TANGGAL}"
```

### 6️⃣ Reject Booking
```
AKSI: Admin klik tombol "Tolak" pada booking pending

MODAL REJECT TERBUKA:
  ┌─────────────────────────────────────┐
  │ TOLAK BOOKING                       │
  ├─────────────────────────────────────┤
  │ Siswa: [NAMA]                       │
  │ Buku: [JUDUL]                       │
  ├─────────────────────────────────────┤
  │ Alasan Penolakan:                   │
  │ [                                   ]│
  │ (min 10 karakter)                   │
  ├─────────────────────────────────────┤
  │ [Batal] [Tolak]                     │
  └─────────────────────────────────────┘

DATABASE UPDATE:
  UPDATE bookings SET 
    status = 'rejected',
    keterangan = [alasan_admin]
  WHERE id = booking.id

  ⚠️ STOK TIDAK DIKURANGI (booking ditolak = buku tidak dipinjam)

NOTIFIKASI:
  📧 Siswa mendapat notifikasi:
    "❌ Booking buku '{Judul}' ditolak"
    "Alasan: {ALASAN}"
    "Bisa membuat booking baru"
```

### 7️⃣ Tracking Booking Approved
```
FILTER: Status = APPROVED

INFORMASI:
  - Booking sudah disetujui
  - Siswa bisa ambil buku di perpustakaan
  - Waiting untuk siswa mengambil & mengembalikan

TOMBOL AKSI:
  ✔️ "Selesai" - Tandai booking sebagai completed
     (Ketika siswa sudah mengembalikan buku)
```

### 8️⃣ Mark as Complete
```
AKSI: Admin klik "Selesai" ketika siswa mengembalikan buku

VALIDASI:
  ✅ Status harus APPROVED
  ✅ Booking belum COMPLETED

DATABASE UPDATE:
  UPDATE bookings SET 
    status = 'completed'
  WHERE id = booking.id

  UPDATE books SET 
    stok_tersedia = stok_tersedia + 1
  WHERE id = booking.book_id
  (Stok ditambah kembali karena buku sudah dikembalikan)

NOTIFIKASI:
  📧 Siswa mendapat notifikasi:
    "✔️ Peminjaman buku '{Judul}' selesai"
    "Terima kasih!"
```

### 9️⃣ View History
```
FILTER: Status = COMPLETED

INFORMASI:
  - Riwayat peminjaman yang sudah selesai
  - Laporan lengkap transaksi
  - Bisa untuk analytics dan laporan
```

---

## 📊 Status Booking Flow

```
┌─────────┐
│ PENDING │  (Menunggu persetujuan admin)
└────┬────┘
     │
     ├──────────────┬──────────────┐
     │              │              │
     ▼              ▼              ▼
 ┌────────┐    ┌────────┐     ┌─────────┐
 │APPROVED│    │REJECTED│     │TIMEOUT? │
 └────┬───┘    └────────┘     └─────────┘
      │             │
      │      (Siswa bisa booking ulang)
      │
      ▼
 ┌─────────────┐
 │  COMPLETED  │  (Buku sudah dikembalikan)
 └─────────────┘
```

---

## 🔑 Database Schema

### Tabel: bookings
```sql
CREATE TABLE bookings (
  id INT PRIMARY KEY AUTO_INCREMENT,
  siswa_id INT NOT NULL,
  book_id INT NOT NULL,
  durasi_diminta INT NOT NULL,              -- durasi yang diminta siswa (fixed)
  durasi_disetujui INT DEFAULT 7,           -- durasi yang diapprove admin (bisa berbeda)
  status ENUM('pending','approved','rejected','completed') DEFAULT 'pending',
  keterangan TEXT NULL,                     -- alasan reject / catatan
  tanggal_booking TIMESTAMP DEFAULT NOW(),  -- saat siswa membuat booking
  tanggal_disetujui TIMESTAMP NULL,         -- saat admin approve
  tanggal_deadline TIMESTAMP NULL,          -- batas waktu kembali (auto-calc: tanggal_diambil + durasi_disetujui)
  tanggal_diambil TIMESTAMP NULL,           -- saat siswa ambil buku di perpustakaan
  tanggal_dikembalikan TIMESTAMP NULL,      -- saat siswa kembalikan buku
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (siswa_id) REFERENCES siswa(id),
  FOREIGN KEY (book_id) REFERENCES books(id)
);
```

**NOTE:** 
- `durasi_diminta` = tidak berubah (apa yang siswa minta)
- `durasi_disetujui` = bisa berbeda dari yang diminta (keputusan admin)
- `tanggal_deadline` = dihitung dari `tanggal_diambil + durasi_disetujui`

### Tabel: books (update)
```sql
ALTER TABLE books ADD COLUMN stok_tersedia INT DEFAULT stok;
-- stok_tersedia berkurang saat booking diapprove
-- stok_tersedia bertambah saat booking dicomplete
```

---

## 🛣️ Routes Reference

### User Routes
```
GET    /booking              → BookingController@index (tampil booking saya)
GET    /booking/buat         → BookingController@create (form booking manual)
POST   /booking              → BookingController@store (submit form booking manual)
POST   /buku/{book}/pinjam   → BookingController@quickBook (booking instant dari halaman buku)
```

⚠️ CLARIFICATION: 
- `quickBook()` = quick booking dari detail buku (recommended UX)
- `store()` = traditional form booking (legacy, alternative)

### Admin Routes
```
GET    /admin/booking                      → BookingController@adminIndex
PATCH  /admin/booking/{booking}/approve    → BookingController@approve
PATCH  /admin/booking/{booking}/reject     → BookingController@reject
PATCH  /admin/booking/{booking}/complete   → BookingController@complete
```

---

## 📱 UI Components

### Untuk User
- ✅ Dashboard Siswa dengan menu "Booking Buku" & "Booking Saya"
- ✅ Grid/Tabel daftar buku dengan tombol "Pinjam"
- ✅ Modal booking untuk pilih durasi
- ✅ Halaman tracking booking dengan status badges
- ✅ Detail booking dengan tombol "Lihat Alasan" jika ditolak

### Untuk Admin
- ✅ Admin dashboard dengan stats booking
- ✅ Tabel booking dengan filter & search
- ✅ Modal approve booking
- ✅ Modal reject booking dengan input alasan
- ✅ Tombol complete untuk tandai selesai
- ✅ View riwayat completed bookings

---

## 🔔 Notification System

| Event | User | Admin |
|-------|------|-------|
| Booking dibuat | ✅ "Booking berhasil, menunggu persetujuan" | ✅ Alert: booking baru menunggu review |
| Booking diapprove | ✅ "Booking disetujui, durasi: X hari, deadline: [DATE]" | ✅ Konfirmasi approve berhasil |
| Booking direject | ✅ "Booking ditolak, alasan: ..." | ✅ Konfirmasi reject berhasil |
| Booking diambil siswa | - | (Optional) Notifikasi siswa ambil buku |
| Booking completed | ✅ "Peminjaman selesai, terima kasih" | ✅ Konfirmasi complete |
| Booking overdue | ⚠️ "Deadline kembali sudah terlewat!" | ⚠️ Ada booking overdue |

---

## ⏱️ Timeline Example

```
HARI 0 (Senin)
  10:00 - Siswa membuat booking buku "Python Programming"
          Status: PENDING
  
  10:05 - Admin approve dengan durasi 7 hari
          Status: APPROVED
          Deadline: Hari 7 (Senin)
          
  10:30 - Siswa ambil buku di perpustakaan

HARI 7 (Senin)
  14:00 - Siswa mengembalikan buku
  
  14:15 - Admin tandai booking COMPLETED
          Stok buku ditambah 1
          
  14:20 - Siswa dapat notifikasi "Peminjaman selesai"
```

---

## ✅ Checklist Implementasi

- [x] Database schema & migration
- [x] Model relationships
- [x] BookingController methods
- [x] Validasi stok & durasi
- [x] User views (index, create, tracking)
- [x] Admin views & modals
- [x] Routes setup
- [x] Flash messages & error handling
- [x] Status badges styling
- [ ] Email notifications (optional)
- [ ] SMS reminders (optional)
- [ ] Denda system integration (for late returns)
