# 🎬 RUNNING TEXT ANIMATIONS - Guide

Panduan lengkap untuk menggunakan animasi **running text yang smooth dan cantik** di monitoring-kos.

---

## 🎯 Jenis Animasi Tersedia

### 1. **Slide In From Left** - Text slides smoothly dari kiri ke kanan

```html
<h1 class="running-text running-text-slide running-text-purple">
    Dashboard Monitoring
</h1>
```

- **Kecepatan Normal**: 0.8s
- **Slow**: `.running-text-slide-slow` (1.2s)
- **Fast**: `.running-text-slide-fast` (0.5s)

### 2. **Typewriter Effect** - Text muncul seperti mesin ketik

```html
<p class="running-text running-text-typewriter running-text-blue">
    Selamat datang di sistem monitoring
</p>
```

- **Kecepatan Normal**: 1.5s dengan efek cursor berkedip
- **Slow**: `.running-text-typewriter-slow` (2.5s)
- **Fast**: `.running-text-typewriter-fast` (0.8s)

### 3. **Word By Word** - Setiap kata muncul satu per satu

```html
<div>
    <span class="running-text running-text-word running-text-cyan"
        >Monitoring</span
    >
    <span
        class="running-text running-text-word running-text-cyan running-text-delay-1"
        >Sistem</span
    >
    <span
        class="running-text running-text-word running-text-cyan running-text-delay-2"
        >Real-time</span
    >
</div>
```

- **Kecepatan Normal**: 0.6s per kata
- **Slow**: `.running-text-word-slow` (1s)
- **Fast**: `.running-text-word-fast` (0.4s)

### 4. **Fade & Slide** - Text fade in sambil slide dari kiri

```html
<h2 class="running-text running-text-fade running-text-green">
    Status Sistem: Online
</h2>
```

- **Kecepatan Normal**: 0.7s
- **Slow**: `.running-text-fade-slow` (1.2s)
- **Fast**: `.running-text-fade-fast` (0.4s)

### 5. **Bounce In** - Text bounce in dari kiri dengan efek spring

```html
<p class="running-text running-text-bounce running-text-pink">
    🎉 Sistem Aktif
</p>
```

- **Kecepatan**: 0.8s dengan cubic-bezier bounce effect

### 6. **Running Loop** - Text bergerak terus-menerus dari kiri ke kanan

```html
<div class="overflow-hidden">
    <p class="running-text running-text-loop running-text-orange">
        🔔 Sistem Monitoring Aktif | Semua Services Berjalan Normal |
    </p>
</div>
```

- **Kecepatan Normal**: 20s (full loop)
- **Slow**: `.running-text-loop-slow` (30s)
- **Fast**: `.running-text-loop-fast` (10s)
- **Pause on Hover**: Otomatis pause saat hover

---

## 🎨 Warna-Warna Tersedia

Gunakan class warna sesuai kebutuhan:

```html
<span class="running-text running-text-slide running-text-purple">Purple</span>
<span class="running-text running-text-slide running-text-blue">Blue</span>
<span class="running-text running-text-slide running-text-cyan">Cyan</span>
<span class="running-text running-text-slide running-text-green">Green</span>
<span class="running-text running-text-slide running-text-pink">Pink</span>
<span class="running-text running-text-slide running-text-indigo">Indigo</span>
<span class="running-text running-text-slide running-text-orange">Orange</span>
<span class="running-text running-text-slide running-text-red">Red</span>
```

| Class                  | Warna     |
| ---------------------- | --------- |
| `.running-text-purple` | 🟣 Ungu   |
| `.running-text-blue`   | 🔵 Biru   |
| `.running-text-cyan`   | 🔷 Cyan   |
| `.running-text-green`  | 🟢 Hijau  |
| `.running-text-pink`   | 🌸 Pink   |
| `.running-text-indigo` | 🟣 Indigo |
| `.running-text-orange` | 🟠 Orange |
| `.running-text-red`    | 🔴 Merah  |

---

## ⏱️ Delay Untuk Staggered Animation

Untuk membuat efek mengalir, gunakan delay pada elemen berturut-turut:

```html
<div>
    <span class="running-text running-text-slide running-text-blue">Teks</span>
    <span
        class="running-text running-text-slide running-text-blue running-text-delay-1"
        >Pertama</span
    >
    <span
        class="running-text running-text-slide running-text-blue running-text-delay-2"
        >Kedua</span
    >
    <span
        class="running-text running-text-slide running-text-blue running-text-delay-3"
        >Ketiga</span
    >
</div>
```

Delay tersedia: `.running-text-delay-1` hingga `.running-text-delay-5` (0.1s - 0.5s)

---

## 📏 Ukuran Text Predefined

```html
<!-- Title -->
<h1
    class="running-text running-text-slide running-text-title running-text-purple"
>
    Judul Besar
</h1>

<!-- Subtitle -->
<h2
    class="running-text running-text-typewriter running-text-subtitle running-text-blue"
>
    Subtitle Medium
</h2>

<!-- Body -->
<p class="running-text running-text-fade running-text-body running-text-cyan">
    Teks body biasa
</p>

<!-- Small -->
<small
    class="running-text running-text-word running-text-small running-text-green"
>
    Teks kecil
</small>
```

---

## 🌈 Gradient Running Text

Kombinasi gradient dengan running animation:

```html
<h1 class="running-text running-text-gradient running-text-title">
    Text dengan Gradient Bergerak
</h1>
```

Gradient secara otomatis menyesuaikan di dark mode.

---

## 💡 Contoh Kombinasi Praktis

### Dashboard Header

```html
<div class="mb-6">
    <h1
        class="running-text running-text-slide running-text-title running-text-purple"
    >
        Dashboard Monitoring KOS
    </h1>
    <p
        class="running-text running-text-fade running-text-subtitle running-text-blue running-text-delay-1"
    >
        Pantau sistem real-time
    </p>
</div>
```

### Status Message

```html
<div class="p-4 bg-blue-50 rounded-lg">
    <p class="running-text running-text-typewriter running-text-blue">
        ✅ Sistem Online - Semua Service Aktif
    </p>
</div>
```

### Alert Notification

```html
<div class="p-4 bg-red-50 rounded-lg">
    <p class="running-text running-text-bounce running-text-red">
        ⚠️ Warning: CPU Usage Tinggi (85%)
    </p>
</div>
```

### Success Notification

```html
<div class="p-4 bg-green-50 rounded-lg">
    <p class="running-text running-text-fade running-text-green">
        ✓ Backup berhasil diselesaikan
    </p>
</div>
```

### Continuous News/Alert Bar

```html
<div
    class="overflow-hidden bg-gradient-to-r from-orange-50 to-yellow-50 p-2 rounded"
>
    <p class="running-text running-text-loop running-text-orange">
        📢 Update Sistem v2.1 Tersedia | Backup Otomatis Berjalan | Maintenance
        Dijadwalkan Minggu Depan |
    </p>
</div>
```

---

## 🎬 Staggered Text Animation

Untuk efek mengalir yang lebih indah:

```html
<div class="flex gap-2">
    <span class="running-text running-text-slide running-text-blue">Hello</span>
    <span
        class="running-text running-text-slide running-text-blue running-text-delay-1"
        >dari</span
    >
    <span
        class="running-text running-text-slide running-text-blue running-text-delay-2"
        >monitoring</span
    >
    <span
        class="running-text running-text-slide running-text-blue running-text-delay-3"
        >system</span
    >
</div>
```

Setiap kata akan muncul secara berurutan dengan delay 0.1s.

---

## 🎯 Use Case & Rekomendasi

| Use Case             | Rekomendasi                                                |
| -------------------- | ---------------------------------------------------------- |
| **Judul Utama**      | `.running-text-slide` atau `.running-text-typewriter`      |
| **Subtitle**         | `.running-text-fade` dengan `.running-text-delay-1`        |
| **Alert/Warning**    | `.running-text-bounce` dengan `.running-text-red`          |
| **Success Message**  | `.running-text-fade` dengan `.running-text-green`          |
| **News Ticker**      | `.running-text-loop` dalam container overflow-hidden       |
| **Status Indicator** | `.running-text-typewriter-fast` dengan sesuai warna status |
| **Emphasis Text**    | `.running-text-bounce` dengan `.running-text-emphasis`     |

---

## ✅ Tips & Best Practices

### ✨ Gunakan untuk:

- **Page Title**: Slide in saat page load
- **Important Messages**: Typewriter atau bounce untuk perhatian
- **Notifications**: Fade in atau slide untuk update
- **Status Display**: Running loop untuk ticker
- **User Feedback**: Quick animations untuk response

### ⚠️ Hindari:

- Terlalu banyak animasi berbeda di halaman yang sama
- Animasi loop pada body text yang panjang
- Menggabungkan 3+ jenis animasi di section yang sama
- Running loop tanpa overflow:hidden pada container

### 🎯 Kombinasi Terbaik:

```html
<!-- Header Section -->
<h1
    class="running-text running-text-slide running-text-purple running-text-title"
>
    Main Title
</h1>
<p
    class="running-text running-text-fade running-text-blue running-text-subtitle running-text-delay-1"
>
    Subtitle dengan delay
</p>

<!-- Status Section -->
<p class="running-text running-text-typewriter running-text-green">
    Status: Online
</p>

<!-- Alert Section -->
<p class="running-text running-text-bounce running-text-red">
    Warning: Perlu Perhatian
</p>
```

---

## 🌙 Dark Mode

Semua warna otomatis beradaptasi dengan dark mode:

```html
<!-- Will look good in both light and dark mode -->
<p class="running-text running-text-slide running-text-purple">
    Text ini terlihat bagus di kedua mode
</p>
```

**Warna Dark Mode** (otomatis lebih terang):

- Purple: `#c084fc`
- Blue: `#60a5fa`
- Cyan: `#22d3ee`
- Green: `#34d399`
- Pink: `#f472b6`
- Indigo: `#a5b4fc`
- Orange: `#fb923c`
- Red: `#f87171`

---

## ♿ Accessibility

### Reduced Motion Support

Jika user memiliki `prefers-reduced-motion: reduce`, animasi akan dinonaktifkan otomatis:

```css
/* Otomatis handled di CSS */
```

### High Contrast Mode

Untuk contrast mode yang lebih tinggi, font weight otomatis naik ke 600.

---

## 📊 Kecepatan Reference

| Tipe           | Normal | Slow | Fast |
| -------------- | ------ | ---- | ---- |
| **Slide**      | 0.8s   | 1.2s | 0.5s |
| **Typewriter** | 1.5s   | 2.5s | 0.8s |
| **Word**       | 0.6s   | 1s   | 0.4s |
| **Fade**       | 0.7s   | 1.2s | 0.4s |
| **Bounce**     | 0.8s   | -    | -    |
| **Loop**       | 20s    | 30s  | 10s  |

---

## 📋 Quick Reference - Copy & Paste

### Slide In Animations

```html
<span class="running-text running-text-slide running-text-purple"
    >Slide Purple</span
>
<span class="running-text running-text-slide running-text-blue"
    >Slide Blue</span
>
<span class="running-text running-text-slide running-text-green"
    >Slide Green</span
>
```

### Typewriter Effects

```html
<span class="running-text running-text-typewriter running-text-purple"
    >Typewriter Purple</span
>
<span class="running-text running-text-typewriter running-text-blue"
    >Typewriter Blue</span
>
```

### Fade & Slide

```html
<span class="running-text running-text-fade running-text-cyan">Fade Cyan</span>
<span class="running-text running-text-fade-slow running-text-pink"
    >Fade Slow Pink</span
>
```

### Bounce

```html
<span class="running-text running-text-bounce running-text-red"
    >Bounce Red</span
>
<span class="running-text running-text-bounce running-text-orange"
    >Bounce Orange</span
>
```

### Running Loop (Ticker)

```html
<div class="overflow-hidden">
    <span class="running-text running-text-loop running-text-orange">
        📢 News Item 1 | News Item 2 | News Item 3 |
    </span>
</div>
```

---

## 🔧 Customization

Untuk membuat animasi kustom, edit `resources/css/running-text.css`:

```css
/* Contoh: Membuat animasi custom */
.running-text-custom {
    animation: customAnimation 1s ease-out forwards;
}

@keyframes customAnimation {
    0% {
        opacity: 0;
        transform: translateX(-50px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}
```

---

## 📝 Implementasi di Blade Template

```blade
<h1 class="running-text running-text-slide running-text-purple">
    {{ $title }}
</h1>

<p class="running-text running-text-fade running-text-blue">
    {{ $subtitle }}
</p>

<!-- Loop untuk status messages -->
<p class="running-text running-text-typewriter running-text-green">
    Status: @if($isOnline) Online @else Offline @endif
</p>
```

---

Nikmati smooth running text animations! 🎬✨
