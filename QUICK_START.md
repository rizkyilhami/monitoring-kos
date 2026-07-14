# 🚀 Quick Start Guide - Firebase & Fonnte Setup

## ⚡ Langkah-langkah Cepat

### 1️⃣ Persiapkan Firebase Service Account Key

```bash
# 1. Download dari Firebase Console
# Settings → Service Accounts → Generate New Private Key

# 2. Pindahkan file ke folder:
mkdir -p storage/app/firebase
mv ~/Downloads/serviceAccountKey.json storage/app/firebase/

# 3. Update .env dengan URL database Anda
FIREBASE_DATABASE_URL=https://your-project-name.firebaseio.com
```

### 2️⃣ Setup Fonnte WhatsApp API

```bash
# 1. Daftar di https://fonnte.com
# 2. Dapatkan API Token dari Dashboard
# 3. Update .env
FONNTE_API_TOKEN=your_token_here
```

### 3️⃣ Setup Database Firebase

Jalankan command untuk membuat data sample:

```bash
php artisan firebase:setup 1
```

Data yang dibuat:
- Arus: 5.2 A
- Daya: 1200 W
- Tagihan: 232500 Rp untuk bulan ini

### 4️⃣ Test Connection

#### Test Firebase
```bash
curl -X GET http://localhost:8000/test/firebase \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Test Fonnte
```bash
curl -X POST http://localhost:8000/test/fonnte \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789"}'
```

#### Test Complete Workflow
```bash
curl -X POST http://localhost:8000/test/workflow \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789"}'
```

---

## 📱 API yang Tersedia

### GET /api/billing/tagihan
Ambil data tagihan untuk user yang login

```javascript
fetch('/api/billing/tagihan')
  .then(r => r.json())
  .then(d => console.log(d))
```

### POST /api/billing/send-whatsapp
Kirim tagihan ke WhatsApp

```javascript
fetch('/api/billing/send-whatsapp', {
  method: 'POST',
  headers: {'Content-Type': 'application/json'},
  body: JSON.stringify({
    user_id: '1',
    phone_number: '08123456789'
  })
})
.then(r => r.json())
.then(d => console.log(d))
```

### GET /api/billing/monitoring
Ambil data arus & daya

```javascript
fetch('/api/billing/monitoring')
  .then(r => r.json())
  .then(d => console.log(d))
```

### POST /api/billing/monitoring/send-whatsapp
Kirim data monitoring ke WhatsApp

---

## 📊 Struktur Data Firebase

```
users/
└── 1/                    (user_id)
    ├── arus
    │   ├── value: 5.2
    │   ├── timestamp: 1623456789
    │   └── unit: "A"
    ├── daya
    │   ├── value: 1200
    │   ├── timestamp: 1623456789
    │   └── unit: "W"
    └── tagihan
        ├── bulan: "Juni 2024"
        ├── no_meter: "12345678"
        ├── penggunaan: 150
        ├── harga_per_kwh: 1550
        ├── total_tagihan: 232500
        ├── status_pembayaran: "Belum Dibayar"
        └── batas_pembayaran: "2024-06-30"
```

---

## 🔧 Mengupdate Data Firebase

### Dari PHP Controller

```php
use App\Services\FirebaseService;

class MyController extends Controller {
    public function update(FirebaseService $firebase) {
        $userId = auth()->user()->id;
        
        // Update arus
        $firebase->updateData("users/$userId/arus", [
            'value' => 6.5,
            'timestamp' => now()->timestamp
        ]);
        
        // Update daya
        $firebase->updateData("users/$userId/daya", [
            'value' => 1500,
            'timestamp' => now()->timestamp
        ]);
        
        // Update tagihan
        $firebase->updateData("users/$userId/tagihan", [
            'status_pembayaran' => 'Lunas',
            'tanggal_pembayaran' => now()->format('Y-m-d')
        ]);
    }
}
```

### Dari Firebase Console

1. Buka [Firebase Console](https://console.firebase.google.com)
2. Pilih Realtime Database
3. Edit data secara manual di UI

---

## 📧 Mengirim WhatsApp

### Format Nomor

Gunakan format internasional: `628123456789`

Atau biarkan service format otomatis:
```php
$phone = $fonteService->formatPhoneNumber('08123456789');
// Result: '628123456789'
```

### Kirim dari Controller

```php
use App\Services\FonteService;

class MyController extends Controller {
    public function send(FonteService $fonte) {
        $hasil = $fonte->sendMessage(
            '628123456789',
            'Halo! Ini adalah pesan test 👋'
        );
        
        if($hasil['success']) {
            // Pesan terkirim
        }
    }
}
```

### Kirim Tagihan Otomatis

```php
$fonte->sendBillingMessage(
    '628123456789',
    [
        'bulan' => 'Juni 2024',
        'penggunaan' => 150,
        'total_tagihan' => 232500,
        'status_pembayaran' => 'Belum Dibayar'
    ]
);
```

---

## ❓ FAQ

### Q: Bagaimana jika nomor WhatsApp salah?
**A:** Service akan memvalidasi format nomor. Format yang valid: `628123456789`

### Q: Data tidak muncul di Firebase?
**A:** Cek:
1. File `serviceAccountKey.json` sudah ada di `storage/app/firebase/`
2. URL database sudah benar di `.env`
3. Jalankan `php artisan config:clear`

### Q: WhatsApp tidak terkirim?
**A:** Cek:
1. Token Fonnte benar di `.env`
2. Nomor WhatsApp terdaftar di Fonnte
3. Quota Fonnte masih ada
4. Lihat log: `tail -f storage/logs/laravel.log`

### Q: Bagaimana cara test tanpa nomor asli?
**A:** Gunakan nomor test dari Fonnte Dashboard atau gunakan endpoint test:
```bash
curl http://localhost:8000/test/config
```

---

## 📚 Dokumentasi Lengkap

Untuk dokumentasi lebih detail, baca: [FIREBASE_FONNTE_SETUP.md](FIREBASE_FONNTE_SETUP.md)

---

## ✅ Checklist Konfigurasi

- [ ] Firebase service account key ada di `storage/app/firebase/serviceAccountKey.json`
- [ ] `FIREBASE_DATABASE_URL` sudah diisi di `.env`
- [ ] `FIREBASE_CREDENTIALS` sudah diisi di `.env`
- [ ] `FONNTE_API_TOKEN` sudah diisi di `.env`
- [ ] Jalankan `php artisan firebase:setup`
- [ ] Test dengan `/test/firebase`
- [ ] Test dengan `/test/fonnte`
- [ ] Test dengan `/test/workflow`
- [ ] Sudah siap production!

---

**Happy Coding! 🎉**
