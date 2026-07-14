<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings - SmarthCost Admin</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            color-scheme: dark;
            font-family: 'Poppins', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #07111f 0%, #111827 45%, #0f172a 100%);
            color: #e2e8f0;
        }

        .page {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 0.9rem;
            min-height: 100vh;
            padding: 0.9rem;
        }

        .panel {
            background: rgba(15, 23, 42, .82);
            border: 1px solid rgba(59, 130, 246, .16);
            border-radius: 1.15rem;
            box-shadow: 0 16px 44px rgba(2, 8, 23, .24);
        }

        .sidebar {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .68rem .8rem;
            border-radius: .95rem;
            color: #cbd5e1;
            text-decoration: none;
            margin-bottom: .28rem;
            transition: all .25s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(59, 130, 246, .16);
            color: #f8fafc;
            transform: translateX(2px);
        }

        .nav-icon {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: .85rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, .12), rgba(139, 92, 246, .08));
            border: 1px solid rgba(96, 165, 250, .18);
            transition: all .35s cubic-bezier(.34, 1.56, .64, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, .1), transparent 70%);
            opacity: 0;
            transition: opacity .3s ease;
        }

        .nav-icon svg {
            width: 20px;
            height: 20px;
            color: #93c5fd;
            transition: all .35s cubic-bezier(.34, 1.56, .64, 1);
            filter: drop-shadow(0 0 4px rgba(59, 130, 246, .3));
        }

        .nav-link:hover .nav-icon,
        .nav-link.active .nav-icon {
            transform: translateY(-2px) scale(1.08);
            background: linear-gradient(135deg, rgba(59, 130, 246, .24), rgba(139, 92, 246, .16));
            border-color: rgba(96, 165, 250, .32);
            box-shadow: 0 12px 28px rgba(59, 130, 246, .22), inset 0 1px 2px rgba(255, 255, 255, .1);
        }

        .nav-link:hover .nav-icon::before,
        .nav-link.active .nav-icon::before {
            opacity: 1;
        }

        .nav-link:hover .nav-icon svg,
        .nav-link.active .nav-icon svg {
            color: #60a5fa;
            filter: drop-shadow(0 0 8px rgba(59, 130, 246, .6));
        }

        @keyframes navPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, .4), 0 12px 28px rgba(59, 130, 246, .22), inset 0 1px 2px rgba(255, 255, 255, .1);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(59, 130, 246, 0), 0 12px 28px rgba(59, 130, 246, .22), inset 0 1px 2px rgba(255, 255, 255, .1);
            }
        }

        .nav-link.active .nav-icon {
            animation: navPulse 2s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-3px)
            }
        }

        .content {
            padding: 1rem;
        }

        .hero {
            padding: 0.9rem 1rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, .16), rgba(139, 92, 246, .12));
            margin-bottom: 0.8rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
        }

        .card {
            padding: .9rem;
            border-radius: .95rem;
            background: rgba(15, 23, 42, .84);
            border: 1px solid rgba(148, 163, 184, .12);
        }

        .chip {
            display: inline-flex;
            padding: .3rem .6rem;
            border-radius: 999px;
            font-size: .74rem;
            background: rgba(59, 130, 246, .16);
            color: #93c5fd;
        }

        @media (max-width: 900px) {
            .page {
                grid-template-columns: 1fr;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <aside class="panel sidebar">
            <div>
                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-700/50">
                    <div class="nav-icon">SC</div>
                    <div>
                        <div class="font-semibold">SmarthCost</div>
                        <div class="text-xs text-slate-400">Admin Panel</div>
                    </div>
                </div>
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="8" height="8" />
                                <rect x="13" y="3" width="8" height="8" />
                                <rect x="3" y="13" width="8" height="8" />
                                <rect x="13" y="13" width="8" height="8" />
                            </svg>
                        </span> Dashboard</a>
                    <a href="{{ route('admin.rooms') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z" />
                                <path d="M3 9V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2" />
                                <path d="M9 13v4M15 13v4" />
                            </svg>
                        </span> Room Management</a>
                    <a href="{{ route('admin.history') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                                <path d="M8 4h8M6 20h12" />
                            </svg>
                        </span> Payment History</a>
                    <a href="{{ route('admin.reports') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <line x1="12" y1="5" x2="7" y2="10" />
                                <line x1="12" y1="5" x2="17" y2="10" />
                            </svg>
                        </span> Laporan</a>
                    <a href="{{ route('admin.settings') }}" class="nav-link active">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M12 1v6M12 17v6M4.22 4.22l4.24 4.24M15.54 15.54l4.24 4.24M1 12h6M17 12h6M4.22 19.78l4.24-4.24M15.54 8.46l4.24-4.24" />
                            </svg>
                        </span> Settings</a>
                </nav>
            </div>
            <div class="text-sm text-slate-400">Tampilan ringan dan nyaman untuk pengaturan admin.</div>
        </aside>
        <main class="panel content">
            <section class="hero">
                <div class="text-xs uppercase tracking-[0.22em] text-slate-400">Settings</div>
                <h1 class="text-xl font-semibold mt-1">Atur preferensi admin dengan cepat</h1>
                <p class="text-sm text-slate-300 mt-1">Konfigurasi ringkas agar halaman lebih bersih dan tidak terasa
                    panjang.</p>
            </section>
            <section class="cards">
                <div class="card">
                    <div class="text-sm text-slate-400">Tema</div>
                    <div class="font-semibold mt-1">Mode gelap otomatis</div>
                    <div class="mt-3"><span class="chip">Aktif</span></div>
                </div>
                <div class="card">
                    <div class="text-sm text-slate-400">Notifikasi</div>
                    <div class="font-semibold mt-1">WhatsApp & Email</div>
                    <div class="mt-3"><span class="chip">Tersambung</span></div>
                </div>
                <div class="card">
                    <div class="text-sm text-slate-400">Pembaharuan</div>
                    <div class="font-semibold mt-1">Data real-time</div>
                    <div class="mt-3"><span class="chip">10 detik</span></div>
                </div>
                <div class="card">
                    <div class="text-sm text-slate-400">Akses</div>
                    <div class="font-semibold mt-1">Admin superuser</div>
                    <div class="mt-3"><span class="chip">Terverifikasi</span></div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
