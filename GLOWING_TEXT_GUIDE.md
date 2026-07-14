# 📝 GLOWING TEXT - Usage Guide

Dokumentasi untuk menggunakan efek **glowing text yang subtle dan elegan** di monitoring-kos.

## 🎨 Warna-Warna Tersedia

Setiap warna memiliki properti yang sesuai untuk menciptakan bersinar yang elegan:

### Warna Dasar dengan Glow

| Class               | Warna     | Deskripsi               |
| ------------------- | --------- | ----------------------- |
| `.text-glow-purple` | 🟣 Ungu   | Sophisticated & Elegant |
| `.text-glow-blue`   | 🔵 Biru   | Professional & Clean    |
| `.text-glow-cyan`   | 🔷 Cyan   | Modern & Trendy         |
| `.text-glow-green`  | 🟢 Hijau  | Fresh & Vibrant         |
| `.text-glow-pink`   | 🌸 Pink   | Elegant & Warm          |
| `.text-glow-indigo` | 🟣 Indigo | Deep & Rich             |
| `.text-glow-orange` | 🟠 Orange | Warm & Inviting         |
| `.text-glow-red`    | 🔴 Red    | Bold & Energetic        |

---

## 💫 Contoh Penggunaan Dasar

### 1. Text Biasa dengan Glow (Tidak Bergerak)

```html
<h1 class="text-glow text-glow-purple">Teks Bersinar Ungu</h1>

<p class="text-glow text-glow-blue">
    Ini adalah paragraf dengan bersinar biru yang elegan
</p>
```

### 2. Text dengan Animasi Pulse (Berdenyut)

```html
<h2 class="text-glow text-glow-cyan animate">Teks Berkedip Cyan</h2>
```

### 3. Text dengan Floating Animation

```html
<span class="text-glow text-glow-pink float"> Teks Melayang </span>
```

### 4. Kombinasi Warna untuk Judul

```html
<div class="text-center">
    <h1 class="text-glow text-glow-purple heading-glow mb-4">
        Dashboard Monitoring
    </h1>
    <p class="text-glow text-glow-blue text-block-glow">
        Pantau sistem Anda dengan gaya yang elegan
    </p>
</div>
```

---

## 🌟 Variasi Intensitas Glow

### Subtle (Minimal & Elegan)

```html
<p class="text-glow-purple text-glow-subtle">
    Glow yang sangat lembut dan minimalis
</p>
```

**Effect**: Filter 3px blur - sangat halus

### Medium (Seimbang & Terlihat)

```html
<p class="text-glow-blue text-glow-medium">
    Glow yang seimbang dan cukup terlihat
</p>
```

**Effect**: Filter 5-8px blur - glow moderate

### Strong (Berani & Menonjol)

```html
<p class="text-glow-pink text-glow-strong">Glow yang kuat namun tetap elegan</p>
```

**Effect**: Filter 6-10px blur - glow yang lebih pronounced

---

## 🎬 Animasi Tersedia

### 1. Pulse - Denyutan Lembut

```html
<span class="text-glow text-glow-purple pulse"> Teks Berdenyut </span>
```

**Efek**: Opacity berubah halus (1 → 0.92 → 1) dalam 2 detik - sangat subtle

### 2. Float - Melayang

```html
<span class="text-glow text-glow-cyan float"> Teks Melayang </span>
```

**Efek**: Teks bergerak naik-turun 1px secara halus - hampir tak terasa

### 3. Shimmer - Kilau

```html
<span class="text-glow text-glow-green shimmer"> Teks Berkilau </span>
```

**Efek**: Efek cahaya bergerak melintas pada teks - subtle dan elegan

### 4. Animate (Built-in Color Pulse)

```html
<span class="text-glow text-glow-orange animate">
    Teks dengan Pulse Warna
</span>
```

**Efek**: Glow berdenyut mengikuti warna teks - gentle dan tidak mengganggu

---

## 🌈 Efek Rainbow/Gradient

### Rainbow Glow

```html
<h1 class="text-glow-rainbow heading-glow">Teks Rainbow Bersinar</h1>
```

**Efek**: Warna berubah-ubah pelangi dengan glow yang dinamis

---

## 📱 Kombinasi dengan Tailwind CSS

### Dengan Text Size

```html
<h1 class="text-4xl font-bold text-glow text-glow-purple">
    Judul Besar Bersinar
</h1>

<p class="text-lg text-glow text-glow-blue">Paragraf Medium Bersinar</p>

<small class="text-glow text-glow-pink text-accent-glow">
    Teks Kecil Bersinar
</small>
```

### Dengan Spacing

```html
<div class="p-4 mb-8">
    <h2 class="text-glow text-glow-indigo mb-4">Subjudul Bersinar</h2>
    <p class="text-glow text-glow-cyan">Konten dengan spacing yang baik</p>
</div>
```

### Dengan Alignment

```html
<div class="text-center">
    <h1 class="text-glow text-glow-purple heading-glow">
        Teks Tengah Bersinar
    </h1>
</div>

<div class="text-right">
    <p class="text-glow text-glow-blue">Teks Kanan Bersinar</p>
</div>
```

---

## 🎯 Contoh Use Case di Dashboard

### Status Card dengan Glow

```html
<div class="bg-white rounded-lg p-6 shadow-lg">
    <p class="text-sm text-gray-500 mb-2">Status Sistem</p>
    <h3 class="text-glow text-glow-green heading-glow mb-2">✅ Online</h3>
    <p class="text-glow text-glow-cyan">Sistem berjalan dengan sempurna</p>
</div>
```

### Alert Message dengan Glow

```html
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <p class="text-glow text-glow-blue font-semibold mb-2">ℹ️ Pemberitahuan</p>
    <p class="text-glow text-glow-cyan">Ada update sistem yang tersedia</p>
</div>
```

### Metric Display dengan Glow

```html
<div class="flex gap-4">
    <div class="flex-1">
        <p class="text-glow text-glow-blue text-accent-glow mb-2">CPU Usage</p>
        <h2 class="text-glow text-glow-purple heading-glow">45%</h2>
    </div>

    <div class="flex-1">
        <p class="text-glow text-glow-green text-accent-glow mb-2">
            Memory Usage
        </p>
        <h2 class="text-glow text-glow-cyan heading-glow">62%</h2>
    </div>
</div>
```

---

## 🌙 Dark Mode

Semua efek glow secara otomatis beradaptasi dengan dark mode:

```html
<!-- Akan menampilkan dengan warna yang lebih cerah di dark mode -->
<p class="text-glow text-glow-purple">
    Teks ini akan bersinar dengan baik di light dan dark mode
</p>
```

**Warna Dark Mode**:

- Purple: `#c084fc` (lebih terang)
- Blue: `#60a5fa` (lebih cerah)
- Cyan: `#22d3ee` (lebih cerah)
- Green: `#34d399` (lebih cerah)
- Pink: `#f472b6` (lebih cerah)
- Indigo: `#a5b4fc` (lebih cerah)
- Orange: `#fb923c` (lebih cerah)
- Red: `#f87171` (lebih cerah)

---

## 🎨 Hover Effect

Semua text glow mendapat efek hover yang subtle:

```html
<!-- Akan sedikit lebih terang saat hover -->
<p class="text-glow text-glow-purple">
    Hover untuk efek brightness yang lembut
</p>
```

**Efek Hover**: `brightness(1.05)` - Membuat teks sedikit lebih terang secara lembut

---

## 📋 Cheat Sheet - Copy & Paste

### Semua Warna Statis (Tidak Bergerak)

```html
<p class="text-glow text-glow-purple">Purple</p>
<p class="text-glow text-glow-blue">Blue</p>
<p class="text-glow text-glow-cyan">Cyan</p>
<p class="text-glow text-glow-green">Green</p>
<p class="text-glow text-glow-pink">Pink</p>
<p class="text-glow text-glow-indigo">Indigo</p>
<p class="text-glow text-glow-orange">Orange</p>
<p class="text-glow text-glow-red">Red</p>
```

### Semua Warna dengan Animasi Pulse

```html
<p class="text-glow text-glow-purple animate">Purple</p>
<p class="text-glow text-glow-blue animate">Blue</p>
<p class="text-glow text-glow-cyan animate">Cyan</p>
<p class="text-glow text-glow-green animate">Green</p>
<p class="text-glow text-glow-pink animate">Pink</p>
<p class="text-glow text-glow-indigo animate">Indigo</p>
<p class="text-glow text-glow-orange animate">Orange</p>
<p class="text-glow text-glow-red animate">Red</p>
```

---

## ⚡ Tips & Best Practices

### ✅ Gunakan untuk:

- **Judul & Heading**: Warna cerah tanpa animasi atau dengan animate yang lembut
- **Pesan Penting**: Gunakan `.animate` untuk subtle attention
- **Dashboard Metrics**: Setiap metrik berwarna berbeda
- **Status Indicator**: Hijau = aktif, Merah = error
- **Emphasis**: Untuk text yang ingin di-highlight tapi tetap elegant

### ❌ Hindari:

- Terlalu banyak glow pada satu halaman (max 2-3 berbeda untuk aesthetic optimal)
- Animasi pada body text panjang (bisa mengganggu reading flow)
- Menggabungkan 4+ warna berbeda di section yang sama
- Mengubah font size dan glow bersamaan

### 🎯 Rekomendasi Kombinasi:

- **Header**: `.text-glow-purple.heading-glow` (primary focus)
- **Subtitle**: `.text-glow-blue` tanpa animasi (secondary)
- **Body**: `.text-glow-cyan` (tanpa animasi)
- **Alert**: `.text-glow-red.animate` (perlu perhatian)
- **Success**: `.text-glow-green` (status indicator)

---

## 📝 Implementasi di Template

### Step 1: Import CSS

CSS sudah diimpor otomatis di `resources/css/app.css`

### Step 2: Gunakan Class di Blade Template

```blade
<h1 class="text-glow text-glow-purple">
    {{ $title }}
</h1>
```

### Step 3: Compile & Test

```bash
npm run dev
# atau
npm run build
```

---

## 🔧 Customization

### Untuk mengubah warna glow sendiri, edit `resources/css/glowing-text.css`:

```css
/* Contoh: Menambah warna custom */
.text-glow-custom {
    color: #your-color;
    text-shadow:
        0 0 10px rgba(r, g, b, 0.5),
        0 0 20px rgba(r, g, b, 0.3),
        0 0 30px rgba(r, g, b, 0.15);
}
```

---

## 🎓 Daftar Lengkap CSS Classes

| Class                | Tipe                     |
| -------------------- | ------------------------ |
| `.text-glow`         | Base class               |
| `.text-glow-purple`  | Warna ungu               |
| `.text-glow-blue`    | Warna biru               |
| `.text-glow-cyan`    | Warna cyan               |
| `.text-glow-green`   | Warna hijau              |
| `.text-glow-pink`    | Warna pink               |
| `.text-glow-indigo`  | Warna indigo             |
| `.text-glow-orange`  | Warna orange             |
| `.text-glow-red`     | Warna merah              |
| `.text-glow-rainbow` | Rainbow gradient         |
| `.text-glow-subtle`  | Glow lembut              |
| `.text-glow-medium`  | Glow seimbang            |
| `.text-glow-strong`  | Glow kuat                |
| `.animate`           | Pulse animation          |
| `.pulse`             | Denyutan opacity         |
| `.float`             | Animasi melayang         |
| `.shimmer`           | Efek kilau               |
| `.heading-glow`      | Style khusus heading     |
| `.text-block-glow`   | Style khusus block text  |
| `.text-accent-glow`  | Style khusus accent text |

---

Nikmati efek bersinar yang elegan! ✨
