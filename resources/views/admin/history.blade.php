<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Pembayaran - SmarthCost Admin</title>
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
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.page-body {
            min-height: 100vh;
            background: linear-gradient(135deg, #07111f 0%, #111827 45%, #0f172a 100%);
            color: #e2e8f0;
            position: relative;
            overflow-x: hidden;
        }

        body.page-body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 15% 20%, rgba(59, 130, 246, 0.14), transparent 24%),
                radial-gradient(circle at 85% 75%, rgba(139, 92, 246, 0.12), transparent 24%);
            pointer-events: none;
            z-index: 0;
        }

        .page-layout {
            display: grid;
            gap: 0.9rem;
            min-height: 100vh;
            padding: 0.9rem;
            position: relative;
            z-index: 1;
        }

        @media (min-width: 1024px) {
            .page-layout {
                grid-template-columns: 260px 1fr;
            }
        }

        .page-sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 1.2rem;
            background: rgba(15, 23, 42, 0.82);
            border: 1px solid rgba(59, 130, 246, 0.16);
            backdrop-filter: blur(10px);
            box-shadow: 0 16px 44px rgba(2, 8, 23, 0.24);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        }

        .sidebar-icon {
            width: 46px;
            height: 46px;
            border-radius: 0.95rem;
            display: grid;
            place-items: center;
            color: white;
            font-weight: 700;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.76), rgba(16, 185, 129, 0.64));
            animation: iconFloat 2.8s ease-in-out infinite;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.7rem 0.8rem;
            border-radius: 0.95rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .nav-link:hover {
            background: rgba(59, 130, 246, 0.14);
            color: #f8fafc;
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.34), rgba(139, 92, 246, 0.22));
            color: #f8fafc;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.18);
        }

        .nav-link .nav-icon {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.85rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(139, 92, 246, 0.08));
            border: 1px solid rgba(96, 165, 250, 0.18);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link .nav-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.1), transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-link .nav-icon svg {
            width: 20px;
            height: 20px;
            color: #93c5fd;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: drop-shadow(0 0 4px rgba(59, 130, 246, 0.3));
        }

        .nav-link:hover .nav-icon,
        .nav-link.active .nav-icon {
            transform: translateY(-2px) scale(1.08);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.24), rgba(139, 92, 246, 0.16));
            border-color: rgba(96, 165, 250, 0.32);
            box-shadow: 0 12px 28px rgba(59, 130, 246, 0.22), inset 0 1px 2px rgba(255, 255, 255, 0.1);
        }

        .nav-link:hover .nav-icon::before,
        .nav-link.active .nav-icon::before {
            opacity: 1;
        }

        .nav-link:hover .nav-icon svg,
        .nav-link.active .nav-icon svg {
            color: #60a5fa;
            filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.6));
        }

        @keyframes navPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(59, 130, 246, 0);
            }
        }

        .nav-link.active .nav-icon {
            animation: navPulse 2s ease-in-out infinite;
        }

        .page-main {
            padding: 1rem;
            border-radius: 1.2rem;
            background: rgba(15, 23, 42, 0.76);
            border: 1px solid rgba(59, 130, 246, 0.14);
            backdrop-filter: blur(10px);
            box-shadow: 0 22px 70px rgba(2, 8, 23, 0.24);
        }

        .header-card,
        .summary-card,
        .room-card,
        .metric-card {
            border-radius: 1rem;
            background: rgba(15, 23, 42, 0.86);
            border: 1px solid rgba(148, 163, 184, 0.12);
            box-shadow: 0 12px 28px rgba(2, 8, 23, 0.16);
        }

        .header-card {
            padding: 1rem 1.1rem;
            margin-bottom: 0.8rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.16), rgba(139, 92, 246, 0.12));
            border-color: rgba(96, 165, 250, 0.16);
        }

        .header-card h1 {
            font-size: clamp(1.3rem, 2vw, 1.6rem);
            font-weight: 700;
            color: #f8fafc;
            line-height: 1.2;
        }

        .header-card p {
            color: #cbd5e1;
            margin-top: 0.3rem;
            max-width: 40rem;
        }

        .hero-inline {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.73rem;
            text-transform: uppercase;
            letter-spacing: 0.22em;
            color: #93c5fd;
            margin-bottom: 0.35rem;
        }

        .hero-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .metric-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.7rem;
            margin-bottom: 0.8rem;
        }

        .metric-card {
            padding: 0.8rem 0.9rem;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
            border-color: rgba(96, 165, 250, 0.24);
        }

        .metric-card.accent {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(139, 92, 246, 0.13));
            border-color: rgba(96, 165, 250, 0.2);
        }

        .metric-card .label {
            color: #94a3b8;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
        }

        .metric-card .value {
            font-size: 1rem;
            font-weight: 700;
            color: #f8fafc;
            margin-top: 0.3rem;
        }

        .metric-card .meta {
            margin-top: 0.25rem;
            color: #93c5fd;
            font-size: 0.74rem;
        }

        .room-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
            margin-bottom: 0.8rem;
        }

        .room-card {
            padding: 0.9rem;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .room-card:hover {
            transform: translateY(-2px);
            border-color: rgba(96, 165, 250, 0.24);
        }

        .room-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.7rem;
        }

        .room-label {
            color: #e2e8f0;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .room-amount {
            font-size: 1.06rem;
            font-weight: 700;
            color: #f8fafc;
            margin-top: 0.18rem;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.32rem 0.66rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-pill.paid {
            background: rgba(16, 185, 129, 0.16);
            color: #4ade80;
        }

        .status-pill.pending {
            background: rgba(251, 191, 36, 0.18);
            color: #fbbf24;
        }

        .mini-bar {
            width: 100%;
            height: 6px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(148, 163, 184, 0.16);
            margin-top: 0.7rem;
        }

        .mini-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.95), rgba(16, 185, 129, 0.8));
        }

        .room-footer {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.55rem;
            margin-top: 0.7rem;
        }

        .summary-card {
            padding: 0.9rem;
        }

        .summary-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .summary-chip {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.16);
            color: #93c5fd;
            font-size: 0.74rem;
            font-weight: 600;
        }

        .small-text {
            color: #94a3b8;
            font-size: 0.78rem;
        }

        .chart-wrap {
            width: 100%;
            height: 220px;
            margin-top: 0.7rem;
            background: rgba(15, 23, 42, 0.4);
            border-radius: 0.95rem;
            padding: 1rem;
            border: 1px solid rgba(59, 130, 246, 0.08);
        }

        .mini-chart {
            width: 100%;
            height: 60px;
            margin-top: 0.8rem;
            background: rgba(10, 16, 35, 0.6);
            border-radius: 0.85rem;
            padding: 0.6rem;
            border: 1px solid rgba(59, 130, 246, 0.06);
        }

        .btn-row {
            display: flex;
            gap: 0.55rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.64rem 0.88rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: rgba(15, 23, 42, 0.75);
            color: #e2e8f0;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            background: rgba(59, 130, 246, 0.16);
        }

        .btn-primary {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.86), rgba(139, 92, 246, 0.76));
            border-color: transparent;
            color: white;
        }

        @media (max-width: 1100px) {

            .metric-grid,
            .room-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 720px) {

            .metric-grid,
            .room-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="page-body">
    @php
        $rooms = ['Kamar 1', 'Kamar 2', 'Kamar 3', 'Kamar 4'];
        $roomsData = [];
        $paidCount = 0;
        $pendingCount = 0;
        foreach ($rooms as $room) {
            $history = [];
            $latestDate = null;
            $latestStatus = 'Belum';
            $latestAmount = 0;
            foreach ($historyByMonth as $month => $records) {
                foreach ($records as $r) {
                    if (($r['name'] ?? '') === $room) {
                        $history[] = [
                            'month' => $month,
                            'amount' => $r['amount'],
                            'status' => $r['status'] ?? 'Belum',
                            'paid_at' => $r['paid_at'] ?? null,
                            'method' => $r['method'] ?? null,
                        ];
                        if (
                            !empty($r['paid_at']) &&
                            (is_null($latestDate) || strtotime($r['paid_at']) > strtotime($latestDate))
                        ) {
                            $latestDate = $r['paid_at'];
                            $latestStatus = $r['status'] ?? 'Belum';
                            $latestAmount = $r['amount'];
                        }
                    }
                }
            }
            if ($latestStatus === 'Lunas') {
                $paidCount++;
            } else {
                $pendingCount++;
            }
            if (empty($history)) {
                $history = [['month' => '—', 'amount' => 0, 'status' => 'Belum', 'paid_at' => null]];
            }
            $trend = array_map(function ($h) {
                return $h['amount'];
            }, $history);
            $roomsData[] = [
                'name' => $room,
                'history' => $history,
                'status' => $latestStatus,
                'current' => $latestAmount,
                'trend' => $trend,
                'method' => $history[0]['method'] ?? '—',
            ];
        }
        $chartMonths = array_keys($historyByMonth);
        $chartTotals = [];
        foreach ($historyByMonth as $m => $records) {
            $sum = 0;
            foreach ($records as $r) {
                $sum += $r['amount'];
            }
            $chartTotals[] = $sum;
        }
    @endphp

    <div class="page-layout">
        <aside class="page-sidebar">
            <div>
                <div class="sidebar-header">
                    <div class="sidebar-icon">SC</div>
                    <div>
                        <div class="text-sm font-semibold">SmarthCost</div>
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
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.rooms') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z" />
                                <path d="M3 9V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2" />
                                <path d="M9 13v4M15 13v4" />
                            </svg>
                        </span>
                        Room Management
                    </a>
                    <a href="{{ route('admin.history') }}" class="nav-link active">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                                <path d="M8 4h8M6 20h12" />
                            </svg>
                        </span>
                        Payment History
                    </a>
                    <a href="{{ route('admin.settings') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M12 1v6M12 17v6M4.22 4.22l4.24 4.24M15.54 15.54l4.24 4.24M1 12h6M17 12h6M4.22 19.78l4.24-4.24M15.54 8.46l4.24-4.24" />
                            </svg>
                        </span>
                        Settings
                    </a>
                </nav>
            </div>
            <div class="small-text">Minimal, clean, and aligned with the reports experience.</div>
        </aside>

        <main class="page-main">
            <section class="header-card">
                <div class="hero-inline">
                    <div>
                        <div class="eyebrow">Riwayat Pembayaran</div>
                        <h1>Pantau status pembayaran kamar dengan tampilan yang lebih bersih</h1>
                        <p>Desain yang lebih minimal, ringan, dan fokus pada ringkasan penting untuk admin.</p>
                    </div>
                    <div class="hero-actions">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">← Dashboard</a>
                        <a href="{{ route('admin.reports') }}" class="btn">Laporan</a>
                    </div>
                </div>
            </section>

            <section class="metric-grid">
                <div class="metric-card accent">
                    <div class="label">Total</div>
                    <div class="value">Rp {{ number_format(array_sum($chartTotals), 0, ',', '.') }}</div>
                    <div class="meta">Rekap 4 kamar</div>
                </div>
                <div class="metric-card">
                    <div class="label">Lunas</div>
                    <div class="value">{{ $paidCount }} kamar</div>
                    <div class="meta">Status aman</div>
                </div>
                <div class="metric-card">
                    <div class="label">Pending</div>
                    <div class="value">{{ $pendingCount }} kamar</div>
                    <div class="meta">Perlu perhatian</div>
                </div>
                <div class="metric-card">
                    <div class="label">Kamar</div>
                    <div class="value">{{ count($roomsData) }} unit</div>
                    <div class="meta">Aktif terpantau</div>
                </div>
            </section>

            <section class="room-grid">
                @foreach ($roomsData as $idx => $room)
                    <article class="room-card">
                        <div class="room-card-top">
                            <div>
                                <div class="room-label">{{ $room['name'] }}</div>
                                <div class="room-amount">Rp {{ number_format($room['current'], 0, ',', '.') }}</div>
                            </div>
                            <span class="status-pill {{ $room['status'] === 'Lunas' ? 'paid' : 'pending' }}">
                                {{ $room['status'] === 'Lunas' ? 'Lunas' : 'Pending' }}
                            </span>
                        </div>
                        <div class="mini-bar">
                            <div class="mini-bar-fill"
                                style="width: {{ min(100, max(12, ($room['current'] / max(1, array_sum($chartTotals))) * 100)) }}%">
                            </div>
                        </div>
                        <div class="room-footer">
                            <div>
                                <div class="small-text">Terakhir</div>
                                <div>{{ $room['history'][0]['paid_at'] ?? '—' }}</div>
                            </div>
                            <div>
                                <div class="small-text">Metode</div>
                                <div>{{ $room['method'] ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="mini-chart">
                            <canvas id="roomSpark-{{ $idx }}" class="w-full h-full"></canvas>
                        </div>
                    </article>
                @endforeach
            </section>

            <section class="summary-card">
                <div class="summary-head">
                    <div>
                        <div class="small-text uppercase tracking-[0.2em]">Ringkasan</div>
                        <h2 class="text-xl font-semibold text-white">Tren pembayaran 4 kamar</h2>
                    </div>
                    <div class="summary-chip">Live overview</div>
                </div>
                <div class="chart-wrap">
                    <canvas id="historyChart" class="w-full h-full"></canvas>
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function() {
            const months = {!! json_encode($chartMonths) !!};
            const totals = {!! json_encode($chartTotals) !!};
            const roomsTrends = {!! json_encode(
                array_map(function ($r) {
                    return $r['trend'];
                }, $roomsData),
            ) !!};

            // Define distinct color palette for each room
            const roomColors = [{
                    border: '#3b82f6',
                    fill: 'rgba(59, 130, 246, 0.15)',
                    glow: 'rgba(59, 130, 246, 0.4)'
                }, // Blue
                {
                    border: '#10b981',
                    fill: 'rgba(16, 185, 129, 0.15)',
                    glow: 'rgba(16, 185, 129, 0.4)'
                }, // Teal
                {
                    border: '#f59e0b',
                    fill: 'rgba(245, 158, 11, 0.15)',
                    glow: 'rgba(245, 158, 11, 0.4)'
                }, // Amber
                {
                    border: '#8b5cf6',
                    fill: 'rgba(139, 92, 246, 0.15)',
                    glow: 'rgba(139, 92, 246, 0.4)'
                }, // Purple
            ];

            // Main history chart
            const historyCtx = document.getElementById('historyChart').getContext('2d');
            const gradient = historyCtx.createLinearGradient(0, 0, 0, 240);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
            gradient.addColorStop(0.5, 'rgba(139, 92, 246, 0.15)');
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0.02)');

            new Chart(historyCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Total Pembayaran',
                        data: totals,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#60a5fa',
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#38bdf8',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        filler: {
                            propagate: true
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: true,
                                color: 'rgba(59, 130, 246, 0.08)',
                                drawBorder: false,
                                drawTicks: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 8
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(59, 130, 246, 0.12)',
                                drawBorder: false,
                                drawTicks: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                callback: value => 'Rp ' + (value / 1000000).toFixed(0) + 'M',
                                padding: 8
                            },
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                },
            });

            // Room trend sparklines with different colors
            roomsTrends.forEach(function(trend, idx) {
                const spark = document.getElementById('roomSpark-' + idx);
                if (!spark) return;
                const colors = roomColors[idx % roomColors.length];
                const sparkCtx = spark.getContext('2d');
                const sparkGradient = sparkCtx.createLinearGradient(0, 0, 0, 60);
                sparkGradient.addColorStop(0, colors.glow);
                sparkGradient.addColorStop(1, 'rgba(15, 23, 42, 0.02)');

                new Chart(spark, {
                    type: 'line',
                    data: {
                        labels: trend.map(function(_, k) {
                            return k + 1;
                        }),
                        datasets: [{
                            data: trend,
                            borderColor: colors.border,
                            backgroundColor: sparkGradient,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            filler: {
                                propagate: true
                            }
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false
                            }
                        },
                    },
                });
            });
        })();
    </script>
</body>

</html>
