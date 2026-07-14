<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎬 Running Text Animations - monitoring-kos</title>
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
            border-left: 4px solid #667eea;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
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

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .demo-box {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .demo-label {
            font-size: 0.85rem;
            color: #666;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .demo-content {
            font-size: 1.1rem;
            font-weight: 500;
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

        .ticker-box {
            background: linear-gradient(90deg, #fef3c7, #fde68a);
            padding: 1rem;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #fde68a;
        }

        .animation-comparison {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }

        .comparison-item {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            border-left: 3px solid #667eea;
            min-height: 80px;
            display: flex;
            align-items: center;
            overflow: hidden;
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

        h2 {
            color: #667eea;
            margin-bottom: 1rem;
        }

        h3 {
            color: #764ba2;
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <div class="container-wide">
        <!-- Page Header -->
        <div class="page-header" style="margin-bottom: 3rem;">
            <h1 class="running-text running-text-slide running-text-title">
                🎬 Running Text Animations
            </h1>
            <p class="running-text running-text-fade running-text-subtitle" style="color: white; margin-top: 1rem;">
                Smooth & Elegant Text Animations untuk Monitoring KOS
            </p>
        </div>

        <!-- Section 1: Slide In -->
        <div class="demo-section">
            <h2>📍 Slide In From Left - Smooth Entry</h2>
            <p class="section-intro">Text slides smoothly dari kiri ke kanan - perfect untuk page load atau emphasis.
            </p>

            <div class="demo-grid">
                <div class="demo-box">
                    <p class="demo-label">Normal Speed (0.8s)</p>
                    <p class="demo-content running-text running-text-slide running-text-purple">
                        Slide In Normal
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Slow (1.2s)</p>
                    <p class="demo-content running-text running-text-slide-slow running-text-blue">
                        Slide In Slow
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Fast (0.5s)</p>
                    <p class="demo-content running-text running-text-slide-fast running-text-green">
                        Slide In Fast
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 2: Typewriter -->
        <div class="demo-section">
            <h2>⌨️ Typewriter Effect - Character by Character</h2>
            <p class="section-intro">Text muncul seperti mesin ketik klasik - sangat engaging untuk messages.</p>

            <div class="demo-grid">
                <div class="demo-box">
                    <p class="demo-label">Normal (1.5s)</p>
                    <p class="demo-content running-text running-text-typewriter running-text-cyan">
                        Typewriter Normal
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Slow (2.5s)</p>
                    <p class="demo-content running-text running-text-typewriter-slow running-text-pink">
                        Typewriter Slow
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Fast (0.8s)</p>
                    <p class="demo-content running-text running-text-typewriter-fast running-text-orange">
                        Typewriter Fast
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 3: Fade & Slide -->
        <div class="demo-section">
            <h2>✨ Fade & Slide - Smooth Entrance</h2>
            <p class="section-intro">Text fade in sambil slide dari kiri - kombinasi halus dan elegan.</p>

            <div class="demo-grid">
                <div class="demo-box">
                    <p class="demo-label">Normal (0.7s)</p>
                    <p class="demo-content running-text running-text-fade running-text-indigo">
                        Fade & Slide
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Slow (1.2s)</p>
                    <p class="demo-content running-text running-text-fade-slow running-text-green">
                        Fade Slow
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Fast (0.4s)</p>
                    <p class="demo-content running-text running-text-fade-fast running-text-red">
                        Fade Fast
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 4: Bounce -->
        <div class="demo-section">
            <h2>🎈 Bounce In - Playful Entry</h2>
            <p class="section-intro">Text bounce in dari kiri - energetik dan eye-catching untuk alerts.</p>

            <div class="demo-grid">
                <div class="demo-box">
                    <p class="demo-label">Bounce (0.8s)</p>
                    <p class="demo-content running-text running-text-bounce running-text-purple">
                        🎉 Bounce In
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Bounce (0.8s)</p>
                    <p class="demo-content running-text running-text-bounce running-text-orange">
                        ⚠️ Bounce In
                    </p>
                </div>

                <div class="demo-box">
                    <p class="demo-label">Bounce (0.8s)</p>
                    <p class="demo-content running-text running-text-bounce running-text-green">
                        ✅ Bounce In
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 5: Word by Word -->
        <div class="demo-section">
            <h2>📝 Word By Word - Sequential Reveal</h2>
            <p class="section-intro">Setiap kata muncul satu per satu dengan delay - efek mengalir yang indah.</p>

            <div
                style="background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%); padding: 1.5rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                <p
                    style="font-size: 0.85rem; color: #666; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">
                    Staggered Word Animation
                </p>
                <div style="line-height: 1.8;">
                    <span class="running-text running-text-word running-text-blue">Monitoring</span>
                    <span class="running-text running-text-word running-text-blue running-text-delay-1">Sistem</span>
                    <span class="running-text running-text-word running-text-blue running-text-delay-2">Real</span>
                    <span class="running-text running-text-word running-text-blue running-text-delay-3">Time</span>
                    <span class="running-text running-text-word running-text-blue running-text-delay-4">Berjalan</span>
                    <span class="running-text running-text-word running-text-blue running-text-delay-5">Sempurna</span>
                </div>
            </div>
        </div>

        <!-- Section 6: Running Loop -->
        <div class="demo-section">
            <h2>🔄 Running Loop - Continuous Scroll</h2>
            <p class="section-intro">Text bergerak terus-menerus seperti ticker - cocok untuk news atau alerts.</p>

            <div style="margin-bottom: 2rem;">
                <p class="demo-label" style="margin-bottom: 1rem;">Normal Speed (20s loop)</p>
                <div class="ticker-box">
                    <p class="demo-content running-text running-text-loop running-text-orange"
                        style="margin: 0; font-size: 1.05rem;">
                        📢 Sistem Monitoring Aktif | Semua Services Berjalan Normal | Backup Otomatis Dijalankan |
                        Database Terupdate | Security Check Passed |
                    </p>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <p class="demo-label" style="margin-bottom: 1rem;">Slow Speed (30s loop)</p>
                <div class="ticker-box" style="background: linear-gradient(90deg, #dbeafe, #bfdbfe);">
                    <p class="demo-content running-text running-text-loop-slow running-text-blue"
                        style="margin: 0; font-size: 1.05rem;">
                        🔔 Notification Alert | Update Tersedia | Maintenance Schedule | Performance Report |
                    </p>
                </div>
            </div>

            <div>
                <p class="demo-label" style="margin-bottom: 1rem;">Fast Speed (10s loop)</p>
                <div class="ticker-box" style="background: linear-gradient(90deg, #f0fdf4, #dcfce7);">
                    <p class="demo-content running-text running-text-loop-fast running-text-green"
                        style="margin: 0; font-size: 1.05rem;">
                        ✅ Success | All Systems Go | Ready to Deploy |
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 7: Text Sizes -->
        <div class="demo-section">
            <h2>📐 Text Sizes - Multiple Options</h2>
            <p class="section-intro">Berbagai ukuran teks yang sudah dikonfigurasi.</p>

            <div style="display: grid; gap: 1.5rem;">
                <div
                    style="background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%); padding: 1.5rem; border-radius: 8px;">
                    <p class="demo-label" style="margin-bottom: 0.5rem;">Title Size (2.5rem)</p>
                    <h1 class="running-text running-text-slide running-text-title running-text-purple">
                        Large Title Text
                    </h1>
                </div>

                <div
                    style="background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%); padding: 1.5rem; border-radius: 8px;">
                    <p class="demo-label" style="margin-bottom: 0.5rem;">Subtitle Size (1.5rem)</p>
                    <h2 class="running-text running-text-fade running-text-subtitle running-text-blue"
                        style="margin: 0;">
                        Medium Subtitle
                    </h2>
                </div>

                <div
                    style="background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%); padding: 1.5rem; border-radius: 8px;">
                    <p class="demo-label" style="margin-bottom: 0.5rem;">Body Size (1rem)</p>
                    <p class="running-text running-text-typewriter running-text-body running-text-green"
                        style="margin: 0;">
                        Regular body text dengan animasi typewriter
                    </p>
                </div>

                <div
                    style="background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%); padding: 1.5rem; border-radius: 8px;">
                    <p class="demo-label" style="margin-bottom: 0.5rem;">Small Size (0.875rem)</p>
                    <small class="running-text running-text-bounce running-text-small running-text-pink">
                        Small accent text dengan bounce animation
                    </small>
                </div>
            </div>
        </div>

        <!-- Section 8: Color Variations -->
        <div class="demo-section">
            <h2>🎨 Color Variations - All Available Colors</h2>
            <p class="section-intro">Semua warna yang tersedia untuk running text animations.</p>

            <div class="animation-comparison">
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-purple">🟣 Purple</p>
                </div>
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-blue">🔵 Blue</p>
                </div>
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-cyan">🔷 Cyan</p>
                </div>
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-green">🟢 Green</p>
                </div>
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-pink">🌸 Pink</p>
                </div>
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-indigo">🟣 Indigo</p>
                </div>
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-orange">🟠 Orange</p>
                </div>
                <div class="comparison-item">
                    <p class="running-text running-text-slide running-text-red">🔴 Red</p>
                </div>
            </div>
        </div>

        <!-- Section 9: Gradient Running Text -->
        <div class="demo-section">
            <h2>🌈 Gradient Running Text</h2>
            <p class="section-intro">Text dengan gradient yang bergerak - untuk emphasis khusus.</p>

            <div
                style="background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%); padding: 2rem; border-radius: 8px; text-align: center;">
                <h1 class="running-text running-text-gradient running-text-title">
                    Gradient Animated Text
                </h1>
            </div>
        </div>

        <!-- Section 10: Real-World Examples -->
        <div class="demo-section">
            <h2>🎯 Real-World Use Cases</h2>
            <p class="section-intro">Contoh implementasi praktis untuk dashboard monitoring.</p>

            <!-- Status Card -->
            <div style="margin-bottom: 2rem;">
                <h3>Dashboard Status Header</h3>
                <div style="background: white; border-left: 4px solid #667eea; padding: 1.5rem; border-radius: 8px;">
                    <h2 class="running-text running-text-slide running-text-purple"
                        style="margin: 0 0 0.5rem 0; font-size: 1.8rem;">
                        Dashboard Monitoring
                    </h2>
                    <p class="running-text running-text-fade running-text-blue running-text-delay-1"
                        style="margin: 0; font-size: 1rem;">
                        Pantau sistem real-time dengan smooth animations
                    </p>
                </div>
            </div>

            <!-- Status Indicators -->
            <div style="margin-bottom: 2rem;">
                <h3>Status Indicators</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div
                        style="background: #f0fdf4; padding: 1rem; border-radius: 8px; border-left: 3px solid #10b981;">
                        <p class="running-text running-text-bounce running-text-green"
                            style="margin: 0; font-weight: 600;">
                            ✅ System Online
                        </p>
                    </div>
                    <div
                        style="background: #fef3c7; padding: 1rem; border-radius: 8px; border-left: 3px solid #f59e0b;">
                        <p class="running-text running-text-typewriter-fast running-text-orange"
                            style="margin: 0; font-weight: 600;">
                            ⚠️ Warning Alert
                        </p>
                    </div>
                    <div
                        style="background: #fef2f2; padding: 1rem; border-radius: 8px; border-left: 3px solid #ef4444;">
                        <p class="running-text running-text-bounce running-text-red"
                            style="margin: 0; font-weight: 600;">
                            ❌ System Error
                        </p>
                    </div>
                </div>
            </div>

            <!-- News Ticker -->
            <div>
                <h3>System News Ticker</h3>
                <div class="ticker-box">
                    <p class="running-text running-text-loop running-text-orange" style="margin: 0;">
                        🔔 Database Backup Completed | All Services Running Smoothly | Performance Optimal | Next
                        Maintenance: Sunday 2AM |
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 11: Code Examples -->
        <div class="demo-section">
            <h2>💻 Contoh Kode</h2>

            <div>
                <h3>Slide In Animation</h3>
                <div class="code-block">
                    <pre>&lt;h1 class="running-text running-text-slide running-text-purple"&gt;
    Dashboard Monitoring
&lt;/h1&gt;</pre>
                </div>
            </div>

            <div>
                <h3>Typewriter Effect</h3>
                <div class="code-block">
                    <pre>&lt;p class="running-text running-text-typewriter running-text-blue"&gt;
    Selamat datang di sistem monitoring
&lt;/p&gt;</pre>
                </div>
            </div>

            <div>
                <h3>Staggered Word Animation</h3>
                <div class="code-block">
                    <pre>&lt;div&gt;
    &lt;span class="running-text running-text-word running-text-cyan"&gt;Monitoring&lt;/span&gt;
    &lt;span class="running-text running-text-word running-text-cyan running-text-delay-1"&gt;Sistem&lt;/span&gt;
    &lt;span class="running-text running-text-word running-text-cyan running-text-delay-2"&gt;Real-time&lt;/span&gt;
&lt;/div&gt;</pre>
                </div>
            </div>

            <div>
                <h3>Running Ticker Loop</h3>
                <div class="code-block">
                    <pre>&lt;div class="overflow-hidden"&gt;
    &lt;p class="running-text running-text-loop running-text-orange"&gt;
        📢 News | Updates | Alerts | 
    &lt;/p&gt;
&lt;/div&gt;</pre>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div
            style="text-align: center; padding: 3rem 0; color: #999; border-top: 1px solid #e2e8f0; margin-top: 3rem;">
            <p>🎬 Running Text Animations - monitoring-kos v1.0</p>
            <p style="font-size: 0.9rem;">Documentation: <code>RUNNING_TEXT_GUIDE.md</code></p>
            <p style="font-size: 0.9rem;">CSS File: <code>resources/css/running-text.css</code></p>
        </div>
    </div>
</body>

</html>
