<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Login - Monitoring Kos</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
    @endif
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        }

        body {
            background: #f4f7fa;
            min-height: 100vh;
        }

        .sidebar {
            background: #0b1e3c;
        }

        .content-area {
            background: #f4f7fa;
            position: relative;
            overflow: hidden;
        }

        /* Gelombang background subtle */
        .content-area::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(21, 101, 216, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .content-area::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(52, 181, 121, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 8px;
            flex-shrink: 0;
        }

        .logo-box svg {
            width: 28px;
            height: 28px;
            color: white;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #a0aec0;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }

        .theme-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            color: #718096;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .theme-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .heading-title {
            font-size: 32px;
            font-weight: 700;
            color: #051d41;
            margin-bottom: 12px;
        }

        .heading-divider {
            width: 48px;
            height: 4px;
            background: #1565d8;
            border-radius: 2px;
            margin: 16px 0;
        }

        .heading-subtitle {
            font-size: 14px;
            color: #718096;
            margin-top: 12px;
        }

        .card-login {
            background: white;
            border-radius: 16px;
            padding: 32px 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
        }

        .card-login:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .icon-wrapper {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 32px;
        }

        .icon-wrapper.admin {
            background: #e6f0ff;
            color: #1565d8;
        }

        .icon-wrapper.user {
            background: #e6f7ed;
            color: #34b579;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .card-desc {
            font-size: 13px;
            color: #718096;
            margin-bottom: 24px;
            line-height: 1.5;
            max-width: 280px;
        }

        .btn-login {
            width: 100%;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            color: white;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-login svg {
            width: 18px;
            height: 18px;
        }

        .btn-admin {
            background: #1565d8;
        }

        .btn-admin:hover {
            background: #0d4bc4;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(21, 101, 216, 0.3);
        }

        .btn-user {
            background: #34b579;
        }

        .btn-user:hover {
            background: #2a9a66;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(52, 181, 121, 0.3);
        }

        .info-banner {
            background: #eaf2ff;
            border: 1px solid #d0e2ff;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-top: 32px;
        }

        .info-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #1565d8;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            font-weight: bold;
        }

        .info-text {
            font-size: 13px;
            color: #2c5282;
            line-height: 1.6;
        }

        .info-text strong {
            color: #1565d8;
            font-weight: 600;
        }

        .footer-copyright {
            font-size: 12px;
            color: #a0aec0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 20px;
            margin-top: auto;
            line-height: 1.6;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 100%;
                height: auto;
                padding: 20px;
            }

            .content-area {
                min-height: auto;
                padding: 40px 20px;
            }

            .heading-title {
                font-size: 28px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .heading-title {
                font-size: 24px;
            }

            .card-login {
                padding: 24px 16px;
            }

            .icon-wrapper {
                width: 72px;
                height: 72px;
            }

            .theme-btn {
                font-size: 12px;
                padding: 6px 12px;
            }
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen flex-col lg:flex-row">
        <!-- SIDEBAR KIRI -->
        <aside class="sidebar w-full lg:w-64 p-6 lg:p-8 flex flex-col justify-between">
            <!-- Bagian Atas Sidebar -->
            <div>
                <!-- Logo & Teks Dashboard -->
                <div class="flex items-center gap-3 mb-12">
                    <div class="logo-box">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white">Dashboard</h1>
                </div>

                <!-- Menu Navigasi -->
                <nav class="space-y-1">
                    <a href="#beranda" class="nav-link active">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <a href="#tentang" class="nav-link">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 8a1 1 0 000 2h4a1 1 0 000-2H8zm4 4H8a1 1 0 000 2h4a1 1 0 000-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Tentang</span>
                    </a>
                    <a href="#login" class="nav-link">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Login</span>
                    </a>
                    <a href="#kontak" class="nav-link">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.727 1.285 2.298 2.756 3.771 1.471 1.47 3.044 2.41 3.771 2.756l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2.57C6.852 18 2 13.148 2 5.43V3z"></path>
                        </svg>
                        <span>Kontak</span>
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="footer-copyright">
                <div>© 2026 Dashboard</div>
                <div>All rights reserved.</div>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="content-area flex-1 p-8 lg:p-12 flex flex-col relative z-0">
            <div class="relative z-10 max-w-4xl mx-auto w-full">
                <!-- Header dengan Tombol Tema -->
                <div class="flex justify-between items-start mb-12">
                    <div>
                        <h2 class="heading-title">Selamat Datang di Dashboard</h2>
                        <div class="heading-divider"></div>
                        <p class="heading-subtitle">Silakan pilih jenis akun untuk login ke sistem.</p>
                    </div>
                    <button class="theme-btn" onclick="toggleTheme()">
                        <span id="sun-icon">☀️</span>
                        <span>Tema</span>
                    </button>
                </div>

                <!-- Grid Kartu Login -->
                <div class="cards-grid grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- KARTU ADMIN -->
                    <div class="card-login">
                        <div class="icon-wrapper admin">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                        </div>
                        <h3 class="card-title">Login Admin</h3>
                        <p class="card-desc">Login untuk administrator untuk mengelola data dan pengaturan sistem.</p>
                        <button class="btn-login btn-admin" onclick="window.location.href='/admin/login'">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span>Login sebagai Admin</span>
                        </button>
                    </div>

                    <!-- KARTU USER -->
                    <div class="card-login">
                        <div class="icon-wrapper user">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                        </div>
                        <h3 class="card-title">Login User</h3>
                        <p class="card-desc">Login untuk pengguna untuk mengakses informasi dan layanan.</p>
                        <button class="btn-login btn-user" onclick="window.location.href='/user/login'">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span>Login sebagai User</span>
                        </button>
                    </div>
                </div>

                <!-- INFO BANNER -->
                <div class="info-banner">
                    <div class="info-icon">i</div>
                    <p class="info-text"><strong>Informasi</strong> Pastikan Anda memiliki akun yang terdaftar untuk dapat login ke sistem.</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleTheme() {
            const sunIcon = document.getElementById('sun-icon');
            const html = document.documentElement;
            
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                sunIcon.textContent = '☀️';
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                sunIcon.textContent = '🌙';
                localStorage.setItem('theme', 'dark');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const sunIcon = document.getElementById('sun-icon');
            const html = document.documentElement;
            
            if (savedTheme === 'dark') {
                html.classList.add('dark');
                sunIcon.textContent = '🌙';
            }
        });
    </script>
</body>

</html>
                    <div class="flex items-center justify-between gap-4 mb-8">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Form login</p>
                            <h3 class="mt-2 text-2xl font-semibold text-white">Masuk ke akun Anda</h3>
                        </div>
                        <div class="rounded-3xl bg-slate-900/80 px-4 py-2 text-slate-200">Akun demo siap pakai</div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-3xl bg-red-950/20 border border-red-600/30 p-4 text-sm text-red-200">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2">
                            <button type="button" onclick="fillDemo('admin@gmail.com','admin123')"
                                class="page-button icon-btn rounded-[2rem] border border-slate-700 bg-slate-900 px-4 py-4 text-left text-slate-200 shadow-lg shadow-slate-950/30 hover:bg-slate-800">
                                <span class="text-2xl">🛡️</span>
                                <div>
                                    <p class="text-sm text-slate-400">Admin Demo</p>
                                    <p class="font-semibold text-white">admin@gmail.com</p>
                                </div>
                            </button>
                            <button type="button" onclick="fillRoomDemo()"
                                class="page-button rounded-[2rem] border border-slate-700 bg-slate-900 px-4 py-4 text-left text-slate-200 shadow-lg shadow-slate-950/30 hover:bg-slate-800">
                                <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Pilih akun kamar demo</p>
                                <select id="demoRoom"
                                    class="mt-3 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20">
                                    <option value="" class="bg-slate-950 text-slate-200">Pilih kamar</option>
                                    <option value="kamar1@gmail.com|user123">Kamar 1</option>
                                    <option value="kamar2@gmail.com|user123">Kamar 2</option>
                                    <option value="kamar3@gmail.com|user123">Kamar 3</option>
                                    <option value="kamar4@gmail.com|user123">Kamar 4</option>
                                </select>
                            </button>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <label class="flex flex-col gap-2 text-sm text-slate-200">
                                <span>Email</span>
                                <input id="emailInput" type="email" name="email" value="{{ old('email') }}"
                                    required
                                    class="rounded-[1.75rem] border border-slate-700 bg-slate-900 px-4 py-4 text-slate-100 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20" />
                            </label>
                            <label class="flex flex-col gap-2 text-sm text-slate-200">
                                <span>Password</span>
                                <input id="passwordInput" type="password" name="password" required
                                    class="rounded-[1.75rem] border border-slate-700 bg-slate-900 px-4 py-4 text-slate-100 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20" />
                            </label>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm text-slate-400">Masukkan email dan password untuk masuk sebagai admin atau
                                penghuni.</p>
                            <button type="submit"
                                class="page-button icon-btn rounded-[2rem] bg-amber-500 px-6 py-4 text-sm font-semibold text-slate-950 shadow-2xl shadow-amber-500/20 hover:bg-amber-400">
                                <span>🚀</span> Masuk Sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <div
                    class="rounded-[2rem] bg-slate-950/95 border border-slate-800 px-6 py-5 text-slate-300 shadow-lg shadow-slate-950/10">
                    <div class="feature-pill">
                        <span>💡</span>
                        <span>Pilih peran lalu gunakan akun demo untuk uji coba cepat.</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function showForm(role) {
            const form = document.getElementById('loginForm');
            form.classList.remove('hidden');
            form.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function fillDemo(email, password) {
            document.getElementById('emailInput').value = email;
            document.getElementById('passwordInput').value = password;
        }

        function fillRoomDemo() {
            const demoRoom = document.getElementById('demoRoom');
            const value = demoRoom.value;
            if (!value) {
                return;
            }
            const [email, password] = value.split('|');
            fillDemo(email, password);
        }
    </script>
</body>

</html>
