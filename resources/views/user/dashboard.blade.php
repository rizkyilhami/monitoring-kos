<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmarthCost Penghuni - {{ $roomNumber ? 'Kamar ' . $roomNumber : 'Dashboard' }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(16, 185, 129, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(16, 185, 129, 0.4) 0%, rgba(34, 197, 94, 0.3) 100%);
            border-radius: 10px;
            border: 2px solid rgba(16, 185, 129, 0.05);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(16, 185, 129, 0.6) 0%, rgba(34, 197, 94, 0.5) 100%);
        }

        body.page-body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #164e63 50%, #0f172a 100%);
            color: #e2e8f0;
            position: relative;
            overflow-x: hidden;
        }

        body.page-body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(34, 197, 94, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .page-layout {
            display: flex;
            gap: 0.9rem;
            min-height: 100vh;
            padding: 0.9rem;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        @media (min-width: 1024px) {
            .page-layout {
                flex-direction: row;
            }
        }

        @media (max-width: 1024px) {
            .page-layout {
                flex-direction: column;
            }
        }

        .page-sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 1rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 280px;
            flex-shrink: 0;
        }

        @media (max-width: 1024px) {
            .page-sidebar {
                width: 100%;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .page-main {
            position: relative;
            padding: 1rem;
            border-radius: 1rem;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.1);
            box-shadow: 0 40px 120px rgba(15, 23, 42, 0.5);
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 1.8rem);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
            flex: 1;
        }

        @media (max-width: 1024px) {
            .sidebar-header {
                margin-bottom: 0;
                padding-bottom: 0;
                border-bottom: none;
            }
        }

        .sidebar-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3) 0%, rgba(34, 197, 94, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-icon svg {
            width: 24px;
            height: 24px;
            color: #6ee7b7;
        }

        .sidebar-header h1 {
            font-size: 1rem;
            font-weight: 700;
            color: #f1f5f9;
            line-height: 1;
        }

        .sidebar-header p {
            font-size: 0.75rem;
            color: #cbd5e1;
            line-height: 1;
        }

        nav.space-y-1 {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            flex: 0;
            margin-bottom: 1rem;
        }

        @media (max-width: 1024px) {
            nav.space-y-1 {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
                margin-bottom: 0;
                flex: 1;
            }
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 0.85rem;
            border-radius: 0.75rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            background: transparent;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(34, 197, 94, 0.15) 100%);
            color: #6ee7b7;
            transform: translateX(3px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.4) 0%, rgba(34, 197, 94, 0.3) 100%);
            color: #a7f3d0;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
            transform: scale(1.02);
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .nav-link span {
            display: inline;
        }

        .content-tabs {
            display: none;
        }

        .content-tabs.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-section {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(34, 197, 94, 0.1) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 1rem;
            padding: 0.9rem;
            margin-bottom: 0.9rem;
            backdrop-filter: blur(10px);
        }

        .header-section h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            background: linear-gradient(135deg, #6ee7b7 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-section p {
            color: #cbd5e1;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.6rem;
            margin-bottom: 0.9rem;
            animation: slideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            animation: slideInStaggered 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.2s;
        }

        @keyframes slideInStaggered {
            from {
                opacity: 0;
                transform: translateY(15px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(34, 197, 94, 0.08) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 0.75rem;
            padding: 0.7rem;
            backdrop-filter: blur(10px);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-4px) scale(1.02);
            border-color: rgba(16, 185, 129, 0.5);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(34, 197, 94, 0.12) 100%);
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3) 0%, rgba(34, 197, 94, 0.2) 100%);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.3rem;
        }

        .stat-icon svg {
            width: 18px;
            height: 18px;
            color: #6ee7b7;
        }

        .stat-label {
            color: #94a3b8;
            font-size: 0.7rem;
            margin-bottom: 0.2rem;
        }

        .stat-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .main-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 41, 59, 0.75) 100%);
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: 1rem;
            padding: 0.9rem;
            backdrop-filter: blur(10px);
            margin-bottom: 0.9rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .main-card:hover {
            border-color: rgba(16, 185, 129, 0.25);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.1);
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.9), rgba(34, 197, 94, 0.7), rgba(16, 185, 129, 0.4), transparent);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.9rem;
            padding-bottom: 0.7rem;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.75rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(34, 197, 94, 0.15) 100%);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 0.6rem;
            color: #6ee7b7;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 320px;
            margin-bottom: 0.9rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(34, 197, 94, 0.02) 100%);
            border-radius: 1rem;
            padding: 1rem;
            border: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 280px;
        }

        .history-table,
        .billing-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .history-table thead tr,
        .billing-table thead tr {
            background: rgba(16, 185, 129, 0.1);
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
        }

        .history-table th,
        .billing-table th {
            padding: 0.65rem;
            text-align: left;
            font-weight: 600;
            color: #6ee7b7;
        }

        .history-table td,
        .billing-table td {
            padding: 0.65rem;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            color: #cbd5e1;
        }

        .history-table tbody tr:hover,
        .billing-table tbody tr:hover {
            background: rgba(16, 185, 129, 0.08);
        }

        .status-lunas {
            color: #10b981;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.6rem;
            background: rgba(16, 185, 129, 0.15);
            border-radius: 0.4rem;
        }

        .status-pending {
            color: #f59e0b;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.6rem;
            background: rgba(245, 158, 11, 0.15);
            border-radius: 0.4rem;
        }

        .profile-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.9rem;
        }

        @media (max-width: 1024px) {
            .profile-info {
                grid-template-columns: 1fr;
            }
        }

        .profile-item {
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .profile-item-label {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-item-value {
            font-size: 1rem;
            font-weight: 600;
            color: #f1f5f9;
        }

        .logout-btn {
            width: 100%;
            padding: 0.65rem 0.75rem;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.3) 0%, rgba(219, 39, 39, 0.2) 100%);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 0.75rem;
            color: #fca5a5;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 0.75rem;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.5) 0%, rgba(219, 39, 39, 0.4) 100%);
            border-color: rgba(239, 68, 68, 0.5);
            transform: translateY(-2px);
        }

        .info-box {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(34, 197, 94, 0.08) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 0.9rem;
            padding: 0.9rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            backdrop-filter: blur(10px);
        }

        .info-box-icon {
            width: 20px;
            height: 20px;
            color: #6ee7b7;
            flex-shrink: 0;
            margin-top: 0.15rem;
        }

        .info-box-content h3 {
            color: #f1f5f9;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
        }

        .info-box-content p {
            color: #cbd5e1;
            font-size: 0.8rem;
        }

        @media (max-width: 1024px) {
            .page-sidebar {
                width: 100%;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .sidebar-header {
                margin-bottom: 0;
                padding-bottom: 0;
                border-bottom: none;
            }

            nav.space-y-1 {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.4rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .profile-info {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-layout {
                padding: 0.6rem;
                gap: 0.6rem;
            }

            .page-sidebar {
                padding: 0.6rem;
            }

            .page-main {
                padding: 0.6rem;
            }

            .header-section {
                padding: 0.65rem;
                margin-bottom: 0.65rem;
            }

            .header-section h2 {
                font-size: 1rem;
            }

            .main-card {
                padding: 0.65rem;
            }

            .stats-grid {
                gap: 0.4rem;
            }

            .stat-card {
                padding: 0.55rem;
            }

            nav.space-y-1 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .page-layout {
                padding: 0.5rem;
                gap: 0.5rem;
            }

            .page-sidebar {
                padding: 0.5rem;
                grid-template-columns: 1fr;
            }

            nav.space-y-1 {
                grid-template-columns: 1fr;
                gap: 0.3rem;
            }

            .nav-link {
                padding: 0.5rem 0.6rem;
                font-size: 0.8rem;
                margin-bottom: 0.2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.35rem;
                margin-bottom: 0.65rem;
            }

            .stat-card {
                padding: 0.5rem;
            }

            .stat-label {
                font-size: 0.65rem;
            }

            .stat-value {
                font-size: 0.95rem;
            }

            .history-table,
            .billing-table {
                font-size: 0.75rem;
            }

            .history-table th,
            .billing-table th,
            .history-table td,
            .billing-table td {
                padding: 0.4rem;
            }
        }
    </style>
</head>

<body class="page-body">
    <div class="page-layout">
        <!-- Sidebar -->
        <aside class="page-sidebar">
            <div>
                <div class="sidebar-header">
                    <div class="sidebar-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h1>SmarthCost</h1>
                        <p>Kamar {{ $roomNumber }}</p>
                    </div>
                    <input type="hidden" id="current-user-id" value="{{ auth()->user()->id ?? '' }}">
                </div>

                <nav class="space-y-1">
                    <a onclick="switchTab(event, 'dashboard')" class="nav-link active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a onclick="switchTab(event, 'history')" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Riwayat</span>
                    </a>
                    <a onclick="switchTab(event, 'billing')" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        <span>Tagihan</span>
                    </a>
                    <a onclick="switchTab(event, 'profile')" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Profil</span>
                    </a>
                </nav>
            </div>

            <div class="rounded-lg border border-red-500/30 bg-red-500/10 p-0.6rem">
                <p class="text-xs font-semibold text-slate-300">{{ $userName }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $room['name'] }}</p>
                <form action="{{ route('logout') }}" method="POST" class="mt-0.5">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width: 14px; height: 14px;">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="page-main">
            <!-- Dashboard Tab -->
            <div id="dashboard" class="content-tabs active">
                <div class="header-section">
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">
                        SmarthCost Penghuni</p>
                    <h2>Dashboard Monitoring</h2>
                    <p>Pantau penggunaan listrik kamar Anda dengan data yang diperbarui setiap 10 detik</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2H3v20h18V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                        </div>
                        <div class="stat-label">Tegangan Saat Ini</div>
                        <div class="stat-value">{{ $room['voltage'] }} <span
                                style="font-size: 0.7em; margin-left: 2px;">V</span></div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="1"></circle>
                                <path
                                    d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24">
                                </path>
                            </svg>
                        </div>
                        <div class="stat-label">Arus Saat Ini</div>
                        <div class="stat-value"><span class="stat-item-number">{{ $room['current'] }}</span> <span
                                style="font-size: 0.7em; margin-left: 2px;">A</span></div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2H3v20h18V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                        </div>
                        <div class="stat-label">Daya Saat Ini</div>
                        <div class="stat-value"><span class="stat-item-number">{{ $room['power'] }}</span> <span
                                style="font-size: 0.7em; margin-left: 2px;">W</span></div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="2" x2="12" y2="22"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <div class="stat-label">Tagihan Bulan Ini</div>
                        <div class="stat-value"><span style="font-size: 0.7em; margin-right: 2px;">Rp</span><span
                                class="stat-item-number">{{ $room['bill'] }}</span></div>
                    </div>
                </div>

                @if (isset($room['monthly']) && is_array($room['monthly']))
                    <div class="main-card"
                        style="margin-top:0.6rem; padding:0.75rem; background: rgba(15,23,42,0.6); border-radius:0.6rem;">
                        <div style="color:#cbd5e1; font-size:0.95rem;">
                            <strong>Bulan:</strong> {{ $room['monthly']['month'] ?? '—' }}
                            &nbsp; • &nbsp;
                            <strong>Estimasi Biaya:</strong>
                            <span style="font-weight:700;">Rp
                                {{ $room['monthly']['tagihan']['total_tagihan'] ?? '—' }}</span>
                        </div>
                    </div>
                @endif

                <div class="main-card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $room['name'] }}</h3>
                        <div class="status-badge {{ strtolower($room['status'] ?? 'offline') }}">
                            {{ $room['status'] ?? 'Offline' }}</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="roomChart"></canvas>
                    </div>
                </div>

                <div class="info-box">
                    <svg class="info-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <div class="info-box-content">
                        <h3>Data Real-Time</h3>
                        <p>Data kamar Anda diperbarui setiap 10 detik untuk memberikan informasi yang akurat dan
                            terkini.</p>
                    </div>
                </div>
            </div>

            <!-- History Tab -->
            <div id="history" class="content-tabs">
                <div class="header-section">
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">
                        SmarthCost Penghuni</p>
                    <h2>Riwayat Penggunaan</h2>
                    <p>Lihat riwayat penggunaan listrik kamar Anda selama 12 bulan terakhir</p>
                </div>

                <div class="main-card">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Penggunaan</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($historyData) && count($historyData) > 0)
                                @foreach ($historyData as $item)
                                    <tr>
                                        <td>{{ $item['month'] }}</td>
                                        <td>{{ $item['power'] }}</td>
                                        <td>{{ $item['bill'] }}</td>
                                        <td>
                                            <span
                                                class="status-{{ strtolower(str_replace(' ', '_', $item['status'])) }}">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="info-box">
                    <svg class="info-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <div class="info-box-content">
                        <h3>Informasi Riwayat</h3>
                        <p>Data riwayat menampilkan penggunaan listrik dan tagihan untuk 12 bulan terakhir.</p>
                    </div>
                </div>
            </div>

            <!-- Billing Tab -->
            <div id="billing" class="content-tabs">
                <div class="header-section">
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">
                        SmarthCost Penghuni</p>
                    <h2>Tagihan Listrik</h2>
                    <p>Lihat detail tagihan listrik kamar Anda</p>
                </div>

                <div class="main-card">
                    <table class="billing-table">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Periode</th>
                                <th>Penggunaan</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($billingData) && count($billingData) > 0)
                                @foreach ($billingData as $item)
                                    <tr>
                                        <td>{{ $item['month'] }}</td>
                                        <td>{{ $item['period'] }}</td>
                                        <td>{{ $item['usage'] }}</td>
                                        <td><strong>{{ $item['amount'] }}</strong></td>
                                        <td>
                                            <span class="status-{{ strtolower($item['status']) }}">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="info-box">
                    <svg class="info-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <div class="info-box-content">
                        <h3>Informasi Tagihan</h3>
                        <p>Pastikan tagihan Anda selalu terbayar pada tanggal jatuh tempo yang telah ditentukan.</p>
                    </div>
                </div>
            </div>

            <!-- Profile Tab -->
            <div id="profile" class="content-tabs">
                <div class="header-section">
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">
                        SmarthCost Penghuni</p>
                    <h2>Profil Penghuni</h2>
                    <p>Informasi lengkap akun dan kamar Anda</p>
                </div>

                <div class="main-card">
                    @if (isset($profileData))
                        <div class="profile-info">
                            <div class="profile-item">
                                <div class="profile-item-label">Nama Lengkap</div>
                                <div class="profile-item-value">{{ $profileData['name'] }}</div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Email</div>
                                <div class="profile-item-value"
                                    style="font-size: 0.85rem; overflow-wrap: break-word;">{{ $profileData['email'] }}
                                </div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Nomor Telepon</div>
                                <div class="profile-item-value">{{ $profileData['phone'] }}</div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Nomor Kamar</div>
                                <div class="profile-item-value">{{ $profileData['room'] }}</div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Bergabung Sejak</div>
                                <div class="profile-item-value">{{ $profileData['joinDate'] }}</div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Status Keanggotaan</div>
                                <div class="profile-item-value" style="color: #6ee7b7;">
                                    {{ $profileData['memberSince'] }}</div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Total Penggunaan</div>
                                <div class="profile-item-value">{{ $profileData['totalUsage'] }}</div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Total Tertagih</div>
                                <div class="profile-item-value">{{ $profileData['totalBilled'] }}</div>
                            </div>
                            <div class="profile-item">
                                <div class="profile-item-label">Tagihan Tertunggak</div>
                                <div class="profile-item-value" style="color: #f59e0b;">
                                    {{ $profileData['outstandingBill'] }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="info-box">
                    <svg class="info-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <div class="info-box-content">
                        <h3>Informasi Profil</h3>
                        <p>Data profil Anda tersimpan dengan aman. Hubungi administrator jika ada yang perlu diubah.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        let roomChartInstance = null;

        function switchTab(event, tabName) {
            event.preventDefault();

            const tabs = document.querySelectorAll('.content-tabs');
            tabs.forEach(tab => tab.classList.remove('active'));

            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => link.classList.remove('active'));

            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }

            event.currentTarget.classList.add('active');

            if (tabName === 'dashboard') {
                setTimeout(() => {
                    initializeChart();
                }, 100);
            }
        }

        function initializeChart() {
            const canvas = document.getElementById('roomChart');
            if (!canvas) return;

            // Destroy existing chart if it exists
            if (roomChartInstance) {
                roomChartInstance.destroy();
                roomChartInstance = null;
            }

            const ctx = canvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, 'rgba(110, 231, 183, 0.3)');
            gradient.addColorStop(1, 'rgba(110, 231, 183, 0.02)');

            roomChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['00:00', '06:00', '12:00', '18:00', '23:59'],
                    datasets: [{
                        label: 'Penggunaan Daya (W)',
                        data: [2200 + Math.random() * 1000, 3500 + Math.random() * 1000, 4200 + Math
                            .random() * 1000, 3800 + Math.random() * 1000, 2500 + Math.random() * 1000
                        ],
                        borderColor: '#6ee7b7',
                        backgroundColor: gradient,
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#a7f3d0',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
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
                        y: {
                            beginAtZero: true,
                            max: 5000,
                            grid: {
                                color: 'rgba(16, 185, 129, 0.1)',
                                drawBorder: false,
                                drawTicks: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                padding: 8
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                padding: 8
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeChart();
        });

        async function fetchMyData() {
            try {
                const userIdEl = document.getElementById('current-user-id');
                const userId = userIdEl ? userIdEl.value : '';
                if (!userId) return null;
                const res = await fetch(`/api/billing/monitoring?user_id=${encodeURIComponent(userId)}`, {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'include',
                    cache: 'no-store'
                });
                if (!res.ok) {
                    console.warn('fetchMyData auth failed', res.status, res.statusText);
                    return null;
                }
                const json = await res.json();
                return json.data ?? null;
            } catch (e) {
                console.warn('fetchMyData error', e);
                return null;
            }
        }

        async function updateMyView() {
            const data = await fetchMyData();
            if (!data) return;
            const arus = data.arus ?? {};
            const daya = data.daya ?? {};
            const tagihan = data.tagihan ?? {};

                document.querySelectorAll('.stat-card .stat-value').forEach(el => {
                    const label = el.parentElement.querySelector('.stat-label')?.textContent?.trim()?.toLowerCase();
                    if (!label) return;
                    const numEl = el.querySelector('.stat-item-number');
                    if (label.includes('tegangan') && arus.voltage && numEl) {
                        numEl.textContent = arus.voltage;
                    }
                    if (label.includes('arus') && arus.current && numEl) {
                        numEl.textContent = arus.current;
                    }
                    if (label.includes('daya') && daya.power && numEl) {
                        numEl.textContent = daya.power;
                    }
                    if (label.includes('tagihan') && tagihan.total_tagihan && numEl) {
                        numEl.textContent = tagihan.total_tagihan;
                    }
                });

            const statusBadge = document.querySelector('.status-badge');
            if (statusBadge && data.status) {
                statusBadge.textContent = data.status;
                statusBadge.classList.remove('online', 'offline');
                statusBadge.classList.add(data.status.toLowerCase());
            }
        }

        updateMyView();
        setInterval(updateMyView, 10000);
    </script>
</body>

</html>
