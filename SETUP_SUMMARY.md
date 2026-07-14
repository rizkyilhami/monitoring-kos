# 📋 Ringkasan Konfigurasi Firebase & Fonnte WhatsApp

Saya telah membuat konfigurasi lengkap untuk mengambil data dari Firebase dan mengirim WhatsApp menggunakan Fonnte. Berikut adalah ringkasannya:

---

## 📦 File-File yang Dibuat

### 🔧 Services (Business Logic)

1. **`app/Services/FirebaseService.php`**
    - Ambil data dari Firebase (arus, daya, tagihan)
    - Simpan/update data ke Firebase
    - Method realtime listening

2. **`app/Services/FonteService.php`**
    - Kirim WhatsApp via Fonnte API
    - Format pesan tagihan dan monitoring
    - Validasi nomor WhatsApp
    - Kirim media (gambar/dokumen)

3. **`app/Services/FonteServiceWithLogging.php`** (Optional)
    - Extend FonteService dengan logging ke database
    - Track history pengiriman
    - Statistik pengiriman

### 🎮 Controllers

1. **`app/Http/Controllers/BillingController.php`**
    - API untuk ambil tagihan
    - API untuk kirim WhatsApp
    - API untuk ambil data monitoring (arus, daya)

2. **`app/Http/Controllers/TestController.php`** (Development only)
    - Test Firebase connection
    - Test Fonnte/WhatsApp
    - Test complete workflow
    - Debug config

### 💾 Database

1. **`database/migrations/2024_06_10_000000_add_whatsapp_integration.php`**
    - Tambah kolom `phone_number` ke users table
    - Table `whatsapp_messages` untuk history
    - Table `user_whatsapp_configs` untuk preferensi

2. **`app/Models/WhatsappMessage.php`**
    - Model untuk tracking pesan WhatsApp
    - Scopes untuk query

### ⚙️ Configuration

- **`.env`** - Ditambah Firebase dan Fonnte config
- **`config/services.php`** - Added Fonnte dan Firebase services
- **`routes/web.php`** - Added API dan test routes

### 📚 Documentation

1. **`QUICK_START.md`** - Panduan cepat setup
2. **`FIREBASE_FONNTE_SETUP.md`** - Dokumentasi lengkap
3. **`app/Console/Commands/SetupFirebaseData.php`** - Command setup test data

---

## 🚀 Langkah-Langkah Setup

### 1. Siapkan Firebase

```bash
# Download service account key dari Firebase Console
# Settings → Service Accounts → Generate New Private Key

# Pindahkan ke folder
mkdir -p storage/app/firebase
mv ~/Downloads/serviceAccountKey.json storage/app/firebase/
chmod 600 storage/app/firebase/serviceAccountKey.json
```

### 2. Update .env

```env
# Firebase Configuration
FIREBASE_PROJECT=app
FIREBASE_CREDENTIALS=storage/app/firebase/serviceAccountKey.json
FIREBASE_DATABASE_URL=https://your-project-name.firebaseio.com

# Fonnte WhatsApp Configuration
FONNTE_API_TOKEN=your_fonnte_token_here
FONNTE_API_URL=https://api.fonnte.com/send
```

### 3. Get Fonnte API Token

```bash
# 1. Daftar di https://fonnte.com
# 2. Koneksikan WhatsApp Business
# 3. Ambil API Token dari Settings/Integration
# 4. Update di .env
```

### 4. Setup Test Data

```bash
php artisan firebase:setup 1
```

### 5. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🧪 Testing

### Test Firebase Connection

```bash
curl -X GET http://localhost:8000/test/firebase \
  -H "Authorization: Bearer TOKEN"
```

### Test Fonnte WhatsApp

```bash
curl -X POST http://localhost:8000/test/fonnte \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789"}'
```

### Test Complete Workflow

```bash
curl -X POST http://localhost:8000/test/workflow \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789"}'
```

---

## 📱 API Endpoints

Semua endpoint memerlukan autentikasi (`auth` middleware).

### Billing

**GET** `/api/billing/tagihan`

- Ambil data tagihan user yang login

**POST** `/api/billing/send-whatsapp`

- Kirim tagihan ke WhatsApp
- Body: `{ "user_id": "1", "phone_number": "08123456789" }`

### Monitoring

**GET** `/api/billing/monitoring`

- Ambil data arus & daya

**POST** `/api/billing/monitoring/send-whatsapp`

- Kirim data monitoring ke WhatsApp

**GET** `/api/billing/arus`

- Ambil data arus saja

**GET** `/api/billing/daya`

- Ambil data daya saja

---

## 📊 Firebase Data Structure

```
users/
├── {user_id}/
│   ├── arus
│   │   ├── value: 5.2
│   │   ├── timestamp: 1623456789
│   │   └── unit: "A"
│   ├── daya
│   │   ├── value: 1200
│   │   ├── timestamp: 1623456789
│   │   └── unit: "W"
│   └── tagihan
│       ├── bulan: "Juni 2024"
│       ├── no_meter: "12345678"
│       ├── penggunaan: 150
│       ├── harga_per_kwh: 1550
│       ├── total_tagihan: 232500
│       ├── status_pembayaran: "Belum Dibayar"
│       └── batas_pembayaran: "2024-06-30"
```

---

## 💻 Contoh Penggunaan

### Dari Laravel Controller

```php
<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use App\Services\FonteService;

class MyController extends Controller
{
    public function example(
        FirebaseService $firebase,
        FonteService $fonte
    ) {
        $userId = auth()->user()->id;
        $phone = auth()->user()->phone_number;

        // 1. Ambil data dari Firebase
        $tagihan = $firebase->getTagihanData($userId);
        $arus = $firebase->getArusData($userId);
        $daya = $firebase->getDayaData($userId);

        // 2. Format nomor WhatsApp
        $phone = $fonte->formatPhoneNumber($phone);

        // 3. Validasi
        if ($fonte->isValidPhoneNumber($phone)) {
            // 4. Kirim WhatsApp
            $result = $fonte->sendBillingMessage($phone, $tagihan);

            if ($result['success']) {
                // Sukses!
            }
        }
    }
}
```

### Dari JavaScript

```javascript
// Ambil tagihan
fetch("/api/billing/tagihan")
    .then((r) => r.json())
    .then((data) => console.log(data));

// Kirim via WhatsApp
fetch("/api/billing/send-whatsapp", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
    },
    body: JSON.stringify({
        user_id: "1",
        phone_number: "08123456789",
    }),
})
    .then((r) => r.json())
    .then((data) => console.log(data));
```

---

## 🔒 Security Checklist

- [ ] Service account key tidak di-commit ke git
- [ ] .env tidak di-commit ke git
- [ ] Firebase rules dikonfigurasi dengan baik
- [ ] API token disimpan di .env, bukan di code
- [ ] Rate limiting ditambahkan ke routes sensitive
- [ ] Input validation dilakukan di semua endpoint
- [ ] Logging diaktifkan untuk tracking

---

## 📁 File Structure Sekarang

```
app/
├── Console/
│   └── Commands/
│       └── SetupFirebaseData.php      ✨ New
├── Http/
│   └── Controllers/
│       ├── BillingController.php      ✨ New
│       └── TestController.php         ✨ New
├── Models/
│   └── WhatsappMessage.php            ✨ New
└── Services/
    ├── FirebaseService.php            ✨ New
    ├── FonteService.php               ✨ New
    └── FonteServiceWithLogging.php    ✨ New

config/
└── services.php                       ✏️ Modified

database/
└── migrations/
    └── 2024_06_10_000000_add_whatsapp_integration.php ✨ New

routes/
└── web.php                            ✏️ Modified

.env                                   ✏️ Modified

Documentation/
├── QUICK_START.md                    ✨ New
└── FIREBASE_FONNTE_SETUP.md          ✨ New
```

---

## ❓ Troubleshooting

### Firebase connection error?

- Cek path `serviceAccountKey.json` di `storage/app/firebase/`
- Jalankan: `php artisan config:clear`

### WhatsApp tidak terkirim?

- Cek token Fonnte di .env
- Verifikasi nomor di Fonnte Dashboard
- Cek logs: `tail -f storage/logs/laravel.log`

### Nomor WhatsApp error?

- Gunakan format: `628123456789` (Indonesia)
- Atau gunakan helper: `$fonte->formatPhoneNumber('08123456789')`

---

## 📞 Next Steps

1. **Baca dokumentasi lengkap:**
    - `QUICK_START.md` untuk setup cepat
    - `FIREBASE_FONNTE_SETUP.md` untuk detail lengkap

2. **Setup database (optional):**

    ```bash
    php artisan migrate
    ```

3. **Test semua endpoint:**
    - `/test/firebase`
    - `/test/fonnte`
    - `/test/workflow`

4. **Integrasikan ke UI:**
    - Tambahkan button di dashboard untuk send WhatsApp
    - Display data monitoring realtime

---

**Status: ✅ Siap Digunakan**

Semua file sudah dikonfigurasi dengan baik. Ikuti langkah setup di atas dan Anda siap untuk:

- ✅ Mengambil data dari Firebase
- ✅ Menampilkan data arus, daya, tagihan
- ✅ Mengirim pesan WhatsApp melalui Fonnte

Selamat coding! 🚀
