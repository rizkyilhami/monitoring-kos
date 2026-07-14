# 📚 Dokumentasi Konfigurasi Firebase & Fonnte WhatsApp

## 📋 Daftar Isi
1. [Persiapan Awal](#persiapan-awal)
2. [Konfigurasi Firebase](#konfigurasi-firebase)
3. [Konfigurasi Fonnte WhatsApp](#konfigurasi-fonnte-whatsapp)
4. [Struktur Data Firebase](#struktur-data-firebase)
5. [API Endpoints](#api-endpoints)
6. [Contoh Penggunaan](#contoh-penggunaan)
7. [Troubleshooting](#troubleshooting)

---

## 🚀 Persiapan Awal

### 1. Install Dependencies
Pastikan sudah menginstall package yang diperlukan:

```bash
composer require guzzlehttp/guzzle
```

### 2. Update .env File
File `.env` sudah dikonfigurasi dengan variable berikut:

```env
# Firebase Configuration
FIREBASE_PROJECT=app
FIREBASE_CREDENTIALS=storage/app/firebase/serviceAccountKey.json
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com

# Fonnte WhatsApp Configuration
FONNTE_API_TOKEN=your_fonnte_api_token
FONNTE_API_URL=https://api.fonnte.com/send
```

---

## 🔥 Konfigurasi Firebase

### 1. Dapatkan Service Account Key
1. Buka [Firebase Console](https://console.firebase.google.com)
2. Pilih project Anda
3. Klik ⚙️ Settings → Project Settings
4. Pilih tab "Service Accounts"
5. Klik "Generate New Private Key"
6. File JSON akan didownload

### 2. Simpan Service Account Key
1. Buat folder jika belum ada:
   ```bash
   mkdir -p storage/app/firebase
   ```

2. Pindahkan file `serviceAccountKey.json` ke:
   ```
   storage/app/firebase/serviceAccountKey.json
   ```

3. Pastikan permissions yang benar:
   ```bash
   chmod 600 storage/app/firebase/serviceAccountKey.json
   ```

### 3. Konfigurasi Database URL
Update `.env` dengan Realtime Database URL Anda:

```env
FIREBASE_DATABASE_URL=https://your-project-name.firebaseio.com
```

Untuk menemukan URL:
1. Di Firebase Console, pilih Realtime Database
2. Salin URL dari tab "Data"

### 4. Setup Firebase Rules (Opsional)
Di Firebase Console → Realtime Database → Rules, setup rules:

```json
{
  "rules": {
    "users": {
      "$uid": {
        ".read": "auth.uid === $uid || root.child('admins').child(auth.uid).exists()",
        ".write": "auth.uid === $uid || root.child('admins').child(auth.uid).exists()",
        "tagihan": {
          ".validate": "newData.hasChildren(['bulan', 'total_tagihan'])"
        },
        "arus": {
          ".validate": "newData.isNumber()"
        },
        "daya": {
          ".validate": "newData.isNumber()"
        }
      }
    }
  }
}
```

---

## 📱 Konfigurasi Fonnte WhatsApp

### 1. Buat Akun Fonnte
1. Kunjungi [https://fonnte.com](https://fonnte.com)
2. Daftar akun
3. Koneksikan WhatsApp Business Anda
4. Selesaikan verifikasi

### 2. Dapatkan API Token
1. Login ke Fonnte Dashboard
2. Klik "Settings" atau "Integration"
3. Salin API Token
4. Update `.env`:

```env
FONNTE_API_TOKEN=your_token_from_fonnte_dashboard
```

### 3. Verifikasi Nomor WhatsApp
- Pastikan nomor WhatsApp sudah terverifikasi di Fonnte
- Test pengiriman di dashboard Fonnte

---

## 📊 Struktur Data Firebase

### Struktur Realtime Database

```
users/
├── {user_id}/
│   ├── arus
│   │   ├── value: 5.2
│   │   └── timestamp: 1623456789
│   ├── daya
│   │   ├── value: 1200
│   │   └── timestamp: 1623456789
│   └── tagihan
│       ├── bulan: "Juni 2024"
│       ├── no_meter: "12345678"
│       ├── penggunaan: 150
│       ├── harga_per_kwh: 1550
│       ├── total_tagihan: 232500
│       ├── status_pembayaran: "Belum Dibayar"
│       └── batas_pembayaran: "2024-06-30"
```

### Format Data untuk Firebase

#### 1. Data Arus (Current)
```php
$firebaseService->saveData('users/user123/arus', [
    'value' => 5.2,  // Ampere
    'timestamp' => now()->timestamp,
    'status' => 'normal'
]);
```

#### 2. Data Daya (Power)
```php
$firebaseService->saveData('users/user123/daya', [
    'value' => 1200,  // Watt
    'timestamp' => now()->timestamp,
    'status' => 'normal'
]);
```

#### 3. Data Tagihan (Billing)
```php
$firebaseService->saveData('users/user123/tagihan', [
    'bulan' => 'Juni 2024',
    'no_meter' => '12345678',
    'penggunaan' => 150,  // kWh
    'harga_per_kwh' => 1550,  // Rp
    'total_tagihan' => 232500,  // Rp
    'status_pembayaran' => 'Belum Dibayar',
    'batas_pembayaran' => '2024-06-30'
]);
```

---

## 🔌 API Endpoints

### Autentikasi
Semua endpoint memerlukan authenticated user. Gunakan middleware `auth`.

### 1. Ambil Data Tagihan
**GET** `/api/billing/tagihan`

Response:
```json
{
  "success": true,
  "data": {
    "bulan": "Juni 2024",
    "no_meter": "12345678",
    "penggunaan": 150,
    "harga_per_kwh": 1550,
    "total_tagihan": 232500,
    "status_pembayaran": "Belum Dibayar",
    "batas_pembayaran": "2024-06-30"
  },
  "timestamp": "2024-06-10T10:30:00.000000Z"
}
```

### 2. Kirim Tagihan via WhatsApp
**POST** `/api/billing/send-whatsapp`

Body:
```json
{
  "user_id": "user123",
  "phone_number": "08123456789"
}
```

Response:
```json
{
  "success": true,
  "message": "Tagihan berhasil dikirim via WhatsApp",
  "data": {
    "status": 200,
    "message": "Message sent"
  }
}
```

### 3. Ambil Data Monitoring (Arus & Daya)
**GET** `/api/billing/monitoring`

Response:
```json
{
  "success": true,
  "data": {
    "arus": {
      "value": 5.2,
      "timestamp": 1623456789,
      "status": "normal"
    },
    "daya": {
      "value": 1200,
      "timestamp": 1623456789,
      "status": "normal"
    },
    "tagihan": {...},
    "timestamp": "2024-06-10T10:30:00.000000Z"
  }
}
```

### 4. Kirim Data Monitoring via WhatsApp
**POST** `/api/billing/monitoring/send-whatsapp`

Body:
```json
{
  "user_id": "user123",
  "phone_number": "08123456789"
}
```

### 5. Ambil Data Arus
**GET** `/api/billing/arus`

### 6. Ambil Data Daya
**GET** `/api/billing/daya`

---

## 💡 Contoh Penggunaan

### Menggunakan Service dari Controller

```php
<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use App\Services\FonteService;

class MyController extends Controller
{
    public function example(FirebaseService $firebaseService, FonteService $fonteService)
    {
        $userId = auth()->user()->id;

        // 1. Ambil data dari Firebase
        $tagihan = $firebaseService->getTagihanData($userId);
        $arus = $firebaseService->getArusData($userId);
        $daya = $firebaseService->getDayaData($userId);

        // 2. Kirim WhatsApp
        $phoneNumber = '08123456789';
        $formattedPhone = $fonteService->formatPhoneNumber($phoneNumber);

        if ($fonteService->isValidPhoneNumber($formattedPhone)) {
            $result = $fonteService->sendBillingMessage($formattedPhone, $tagihan);

            if ($result['success']) {
                // Handle success
            }
        }
    }
}
```

### Menggunakan API dari JavaScript

```javascript
// Ambil data tagihan
fetch('/api/billing/tagihan', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
})
.then(response => response.json())
.then(data => console.log('Tagihan:', data));

// Kirim tagihan via WhatsApp
fetch('/api/billing/send-whatsapp', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        user_id: 'user123',
        phone_number: '08123456789'
    })
})
.then(response => response.json())
.then(data => console.log('Result:', data));

// Ambil data monitoring realtime
async function getMonitoring() {
    const response = await fetch('/api/billing/monitoring');
    const data = await response.json();
    console.log('Arus:', data.data.arus);
    console.log('Daya:', data.data.daya);
}

// Kirim monitoring data via WhatsApp
async function sendMonitoring() {
    const response = await fetch('/api/billing/monitoring/send-whatsapp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            user_id: 'user123',
            phone_number: '08123456789'
        })
    });
    const data = await response.json();
    console.log('Result:', data);
}
```

### Menggunakan dengan Axios (Vue.js/React)

```javascript
import axios from 'axios';

// Setup default headers
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

// Ambil tagihan
const getTagihan = async (userId) => {
    try {
        const { data } = await axios.get('/api/billing/tagihan', {
            params: { user_id: userId }
        });
        return data;
    } catch (error) {
        console.error('Error:', error);
    }
};

// Kirim tagihan via WhatsApp
const sendTagihanWhatsApp = async (userId, phoneNumber) => {
    try {
        const { data } = await axios.post('/api/billing/send-whatsapp', {
            user_id: userId,
            phone_number: phoneNumber
        });
        return data;
    } catch (error) {
        console.error('Error:', error);
    }
};
```

---

## 📝 Menambah Data ke Firebase

### Menggunakan Admin SDK (Backend)

```php
// Dari Controller atau Service
use App\Services\FirebaseService;

class DataController extends Controller
{
    public function saveArusData(FirebaseService $firebaseService)
    {
        $userId = 'user123';
        $arusValue = 5.2;

        $firebaseService->saveData("users/{$userId}/arus", [
            'value' => $arusValue,
            'timestamp' => now()->timestamp,
            'unit' => 'A'
        ]);
    }

    public function updateTagihan(FirebaseService $firebaseService)
    {
        $userId = 'user123';

        $firebaseService->updateData("users/{$userId}/tagihan", [
            'total_tagihan' => 250000,
            'status_pembayaran' => 'Lunas',
            'tanggal_pembayaran' => now()->format('Y-m-d')
        ]);
    }
}
```

### Menggunakan Firebase Console (Manual)
1. Buka Firebase Console
2. Pilih Realtime Database
3. Klik ➕ untuk menambah data
4. Atur struktur sesuai contoh di atas

---

## 🐛 Troubleshooting

### Error: "Firebase service account file not found"

**Solusi:**
1. Pastikan file `serviceAccountKey.json` ada di:
   ```
   storage/app/firebase/serviceAccountKey.json
   ```
2. Update `.env`:
   ```env
   FIREBASE_CREDENTIALS=storage/app/firebase/serviceAccountKey.json
   ```
3. Jalankan:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Error: "Fonnte API Token tidak valid"

**Solusi:**
1. Cek token di Fonnte Dashboard
2. Pastikan `.env` dikonfigurasi dengan benar:
   ```env
   FONNTE_API_TOKEN=your_actual_token
   ```
3. Test connection dengan curl:
   ```bash
   curl -X POST https://api.fonnte.com/send \
     -H "Authorization: your_token" \
     -H "Content-Type: application/json" \
     -d '{"target":"628123456789","message":"Test"}'
   ```

### Error: "Nomor WhatsApp tidak valid"

**Solusi:**
1. Gunakan format yang benar: `628123456789` (tanpa +, spasi, atau dash)
2. Gunakan helper function:
   ```php
   $fonteService->formatPhoneNumber('08123456789');  // Akan convert ke 628123456789
   ```

### WhatsApp tidak terkirim tapi tidak ada error

**Solusi:**
1. Cek logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```
2. Verifikasi nomor sudah terdaftar di Fonnte
3. Pastikan quota WhatsApp belum habis
4. Cek rate limiting Fonnte

### Firebase Data tidak terupdate

**Solusi:**
1. Cek Firebase Rules di Console
2. Pastikan user memiliki permission untuk write
3. Verifikasi struktur path yang benar
4. Lihat error di Laravel logs

---

## 🔐 Security Best Practices

1. **Jangan commit credentials:**
   ```bash
   echo "storage/app/firebase/" >> .gitignore
   echo ".env" >> .gitignore
   ```

2. **Setup Firebase Rules yang ketat:**
   - Jangan allow read/write tanpa auth
   - Validate data structure

3. **Rate Limiting:**
   Tambahkan throttling ke routes:
   ```php
   Route::middleware('throttle:60,1')->group(function () {
       Route::post('/api/billing/send-whatsapp', [...]);
   });
   ```

4. **Encrypt Sensitive Data:**
   ```php
   // Di model atau database
   protected $encrypted = ['phone_number'];
   ```

---

## 📞 Support

Jika ada pertanyaan atau error:
1. Cek dokumentasi Firebase: https://firebase.google.com/docs
2. Cek dokumentasi Fonnte: https://fonnte.com/docs
3. Cek Laravel documentation: https://laravel.com/docs
4. Lihat logs di `storage/logs/laravel.log`

---

**Created:** 2024-06-10  
**Last Updated:** 2024-06-10
