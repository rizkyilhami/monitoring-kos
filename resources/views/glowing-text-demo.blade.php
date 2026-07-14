<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌟 Glowing Text Demo - monitoring-kos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #f8f9fa 100%);
            font-family: 'Instrument Sans', sans-serif;
        }

        .demo-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            border-left: 4px solid #9333ea;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .demo-box {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .demo-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .demo-label {
            font-size: 0.85rem;
            color: #666;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
        }

        .page-header h1 {
            font-size: 3rem;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .page-header p {
            font-size: 1.1rem;
            margin: 0.5rem 0 0 0;
            opacity: 0.95;
        }

        .color-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .color-demo {
            padding: 2rem;
            border-radius: 8px;
            background: white;
            border: 2px solid #e2e8f0;
            text-align: center;
        }

        .animation-example {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 2rem;
            background: white;
            border-radius: 8px;
        }

        .animation-item {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%);
            border-radius: 6px;
            text-align: center;
        }

        .combination-showcase {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            padding: 2rem;
            border-radius: 12px;
            border: 2px dashed #667eea;
        }

        .card-example {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        code {
            background: #f5f5f5;
            padding: 0.3rem 0.6rem;
            border-radius: 3px;
            font-size: 0.9rem;
            color: #e11d48;
        }

        .code-block {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 1rem;
            border-radius: 6px;
            overflow-x: auto;
            margin: 1rem 0;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
        }

        pre {
            margin: 0;
        }

        .section-intro {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .container-wide {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
    </style>
</head>

<body>
    <div class="container-wide">
        <!-- Page Header -->
        <div class="page-header" style="margin-bottom: 3rem;">
            <h1>✨ Glowing Text Effects</h1>
            <p>Teks Bersinar Elegan untuk Aplikasi Monitoring KOS</p>
        </div>

        <!-- Section 1: Warna Dasar -->
        <div class="demo-section">
            <h2 style="color: #667eea; margin-bottom: 1rem;">🎨 Warna-Warna Tersedia</h2>
            <p class="section-intro">
                Setiap warna memiliki glow yang sesuai. Pilih warna yang tepat untuk mengkomunikasikan pesan Anda.
            </p>

            <div class="color-grid">
                <div class="color-demo">
                    <p class="demo-label">Ungu - Sophisticated</p>
                    <p class="text-glow text-glow-purple demo-title">Ungu</p>
                </div>

                <div class="color-demo">
                    <p class="demo-label">Biru - Professional</p>
                    <p class="text-glow text-glow-blue demo-title">Biru</p>
                </div>

                <div class="color-demo">
                    <p class="demo-label">Cyan - Modern</p>
                    <p class="text-glow text-glow-cyan demo-title">Cyan</p>
                </div>

                <div class="color-demo">
                    <p class="demo-label">Hijau - Fresh</p>
                    <p class="text-glow text-glow-green demo-title">Hijau</p>
                </div>

                <div class="color-demo">
                    <p class="demo-label">Pink - Elegant</p>
                    <p class="text-glow text-glow-pink demo-title">Pink</p>
                </div>

                <div class="color-demo">
                    <p class="demo-label">Indigo - Rich</p>
                    <p class="text-glow text-glow-indigo demo-title">Indigo</p>
                </div>

                <div class="color-demo">
                    <p class="demo-label">Orange - Warm</p>
                    <p class="text-glow text-glow-orange demo-title">Orange</p>
                </div>

                <div class="color-demo">
                    <p class="demo-label">Merah - Bold</p>
                    <p class="text-glow text-glow-red demo-title">Merah</p>
                </div>
            </div>
        </div>

        <!-- Section 2: Dengan Animasi -->
        <div class="demo-section">
            <h2 style="color: #667eea; margin-bottom: 1rem;">💫 Dengan Animasi</h2>
            <p class="section-intro">
                Tambahkan class <code>.animate</code> untuk membuat glow berdenyut menarik perhatian.
            </p>

            <div class="animation-example">
                <div class="animation-item">
                    <p class="demo-label">Pulse Animation</p>
                    <p class="text-glow text-glow-purple animate demo-title">Berdenyut</p>
                </div>

                <div class="animation-item">
                    <p class="demo-label">Float Animation</p>
                    <p class="text-glow text-glow-blue float demo-title">Melayang</p>
                </div>

                <div class="animation-item">
                    <p class="demo-label">Shimmer Animation</p>
                    <p class="text-glow text-glow-cyan shimmer demo-title">Berkilau</p>
                </div>

                <div class="animation-item">
                    <p class="demo-label">Pulse Animation</p>
                    <p class="text-glow text-glow-green pulse demo-title">Denyut</p>
                </div>
            </div>
        </div>

        <!-- Section 3: Intensitas Glow -->
        <div class="demo-section">
            <h2 style="color: #667eea; margin-bottom: 1rem;">🌟 Intensitas Glow</h2>
            <p class="section-intro">
                Sesuaikan intensitas glow sesuai kebutuhan Anda.
            </p>

            <div class="demo-grid">
                <div class="demo-box">
                    <div>
                        <p class="demo-label">Subtle</p>
                        <p class="text-glow text-glow-purple text-glow-subtle demo-title">Lembut</p>
                    </div>
                </div>

                <div class="demo-box">
                    <div>
                        <p class="demo-label">Medium</p>
                        <p class="text-glow text-glow-blue text-glow-medium demo-title">Seimbang</p>
                    </div>
                </div>

                <div class="demo-box">
                    <div>
                        <p class="demo-label">Strong</p>
                        <p class="text-glow text-glow-pink text-glow-strong demo-title">Kuat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Kombinasi Realistis -->
        <div class="demo-section">
            <h2 style="color: #667eea; margin-bottom: 1rem;">🎯 Use Case: Dashboard Monitoring</h2>
            <p class="section-intro">
                Contoh implementasi di dashboard monitoring sistem real-world.
            </p>

            <!-- Status Cards -->
            <div style="margin-bottom: 2rem;">
                <h3 style="color: #764ba2; margin-bottom: 1rem;">Status System Cards</h3>
                <div class="demo-grid">
                    <div class="card-example">
                        <p class="text-glow text-glow-green text-accent-glow mb-2">✅ Status</p>
                        <h3 class="text-glow text-glow-green demo-title">Online</h3>
                        <p class="text-glow text-glow-cyan">Sistem berjalan sempurna</p>
                    </div>

                    <div class="card-example">
                        <p class="text-glow text-glow-yellow text-accent-glow mb-2">⚠️ Status</p>
                        <h3 class="text-glow text-glow-orange demo-title">Warning</h3>
                        <p class="text-glow text-glow-orange">CPU Usage tinggi</p>
                    </div>

                    <div class="card-example">
                        <p class="text-glow text-glow-red text-accent-glow mb-2">❌ Status</p>
                        <h3 class="text-glow text-glow-red demo-title">Offline</h3>
                        <p class="text-glow text-glow-red animate">Koneksi terputus</p>
                    </div>
                </div>
            </div>

            <!-- Metrics Display -->
            <div style="margin-bottom: 2rem;">
                <h3 style="color: #764ba2; margin-bottom: 1rem;">System Metrics</h3>
                <div class="card-example">
                    <div class="demo-grid">
                        <div>
                            <p class="text-glow text-glow-blue text-accent-glow mb-2">CPU Usage</p>
                            <p class="text-glow text-glow-purple demo-title">45%</p>
                            <p style="color: #999; font-size: 0.9rem;">Normal</p>
                        </div>
                        <div>
                            <p class="text-glow text-glow-cyan text-accent-glow mb-2">Memory Usage</p>
                            <p class="text-glow text-glow-cyan demo-title">62%</p>
                            <p style="color: #999; font-size: 0.9rem;">Optimal</p>
                        </div>
                        <div>
                            <p class="text-glow text-glow-green text-accent-glow mb-2">Disk Usage</p>
                            <p class="text-glow text-glow-green demo-title">38%</p>
                            <p style="color: #999; font-size: 0.9rem;">Available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Rainbow & Special Effects -->
        <div class="demo-section">
            <h2 style="color: #667eea; margin-bottom: 1rem;">🌈 Special Effects</h2>
            <p class="section-intro">
                Efek khusus untuk membuat UI yang lebih menarik.
            </p>

            <div class="card-example" style="text-align: center;">
                <p class="demo-label" style="margin-bottom: 1rem;">Rainbow Gradient Glow</p>
                <h1 class="text-glow-rainbow heading-glow" style="font-size: 2.5rem;">Rainbow Text</h1>
            </div>
        </div>

        <!-- Section 6: Code Examples -->
        <div class="demo-section">
            <h2 style="color: #667eea; margin-bottom: 1rem;">💻 Cara Penggunaan</h2>

            <div style="margin-bottom: 2rem;">
                <h3 style="color: #764ba2; margin-bottom: 1rem;">Contoh 1: Teks Biasa</h3>
                <div class="code-block">
                    <pre>&lt;h1 class="text-glow text-glow-purple"&gt;
    Judul Bersinar
&lt;/h1&gt;</pre>
                </div>
                <p class="text-glow text-glow-purple demo-title" style="margin-top: 1rem;">Hasil Preview</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="color: #764ba2; margin-bottom: 1rem;">Contoh 2: Dengan Animasi</h3>
                <div class="code-block">
                    <pre>&lt;p class="text-glow text-glow-blue animate"&gt;
    Teks Berdenyut
&lt;/p&gt;</pre>
                </div>
                <p class="text-glow text-glow-blue animate demo-title" style="margin-top: 1rem;">Hasil Preview</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="color: #764ba2; margin-bottom: 1rem;">Contoh 3: Kombinasi dengan Tailwind</h3>
                <div class="code-block">
                    <pre>&lt;div class="flex gap-4"&gt;
    &lt;h2 class="text-2xl font-bold text-glow text-glow-purple"&gt;
        Dashboard
    &lt;/h2&gt;
    &lt;p class="text-glow text-glow-cyan"&gt;
        Monitoring Status
    &lt;/p&gt;
&lt;/div&gt;</pre>
                </div>
                <div style="margin-top: 1rem; padding: 1.5rem; background: #f8fafc; border-radius: 6px;">
                    <h2 class="text-2xl font-bold text-glow text-glow-purple" style="margin: 0 0 0.5rem 0;">
                        Dashboard
                    </h2>
                    <p class="text-glow text-glow-cyan">
                        Monitoring Status
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 7: Tips & Best Practices -->
        <div class="demo-section">
            <h2 style="color: #667eea; margin-bottom: 1rem;">💡 Tips & Best Practices</h2>

            <div style="display: grid; gap: 1.5rem;">
                <div style="padding: 1rem; background: #d4f4dd; border-left: 4px solid #10b981; border-radius: 6px;">
                    <h4 style="color: #10b981; margin: 0 0 0.5rem 0;">✅ Gunakan Untuk</h4>
                    <ul style="margin: 0; padding-left: 1.5rem; color: #666;">
                        <li>Judul dan heading penting</li>
                        <li>Status indicator sistem</li>
                        <li>Metrik dashboard yang penting</li>
                        <li>Alert dan notifikasi</li>
                    </ul>
                </div>

                <div style="padding: 1rem; background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 6px;">
                    <h4 style="color: #d97706; margin: 0 0 0.5rem 0;">⚠️ Hindari</h4>
                    <ul style="margin: 0; padding-left: 1.5rem; color: #666;">
                        <li>Terlalu banyak glow pada satu halaman</li>
                        <li>Glow kuat untuk body text panjang</li>
                        <li>Animasi pada teks yang sering dibaca</li>
                        <li>Warna glow terlalu mirip</li>
                    </ul>
                </div>

                <div style="padding: 1rem; background: #dbeafe; border-left: 4px solid #3b82f6; border-radius: 6px;">
                    <h4 style="color: #1d4ed8; margin: 0 0 0.5rem 0;">🎯 Rekomendasi</h4>
                    <ul style="margin: 0; padding-left: 1.5rem; color: #666;">
                        <li><strong>Header:</strong> Purple dengan heading-glow</li>
                        <li><strong>Subtitle:</strong> Blue dengan animate</li>
                        <li><strong>Body:</strong> Cyan tanpa animasi</li>
                        <li><strong>Alert:</strong> Red dengan animate</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div
            style="text-align: center; padding: 3rem 0; color: #999; border-top: 1px solid #e2e8f0; margin-top: 3rem;">
            <p>✨ Glowing Text Effects - monitoring-kos v1.0</p>
            <p style="font-size: 0.9rem;">Documentation: <code>GLOWING_TEXT_GUIDE.md</code></p>
            <p style="font-size: 0.9rem;">CSS File: <code>resources/css/glowing-text.css</code></p>
        </div>
    </div>
</body>

</html>
