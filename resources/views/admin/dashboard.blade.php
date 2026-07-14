<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmarthCost Admin</title>
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

        body.page-body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
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
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .page-layout {
            display: grid;
            gap: 1.5rem;
            min-height: 100vh;
            padding: 2rem;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        @media (min-width: 1024px) {
            .page-layout {
                grid-template-columns: 280px 1fr;
            }
        }

        .page-sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2rem;
            border-radius: 2rem;
            border: 1px solid rgba(59, 130, 246, 0.2);
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .page-main {
            position: relative;
            padding: 2rem;
            border-radius: 2rem;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.1);
            box-shadow: 0 40px 120px rgba(15, 23, 42, 0.5);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        }

        .sidebar-icon {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-icon svg {
            width: 24px;
            height: 24px;
            color: #60a5fa;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 1rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(139, 92, 246, 0.15) 100%);
            color: #60a5fa;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.4) 0%, rgba(139, 92, 246, 0.3) 100%);
            color: #93c5fd;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
        }

        .page-layout {
            gap: 0.9rem;
            padding: 0.9rem;
        }

        .page-sidebar {
            padding: 0.95rem;
            border-radius: 1.2rem;
        }

        .page-main {
            padding: 0.95rem;
            border-radius: 1.2rem;
        }

        .sidebar-header {
            gap: 0.7rem;
            margin-bottom: 0.9rem;
            padding-bottom: 0.9rem;
        }

        .nav-link {
            padding: 0.68rem 0.78rem;
            margin-bottom: 0.28rem;
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
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4), 0 12px 28px rgba(59, 130, 246, 0.22), inset 0 1px 2px rgba(255, 255, 255, 0.1);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(59, 130, 246, 0), 0 12px 28px rgba(59, 130, 246, 0.22), inset 0 1px 2px rgba(255, 255, 255, 0.1);
            }
        }

        .nav-link.active .nav-icon {
            animation: navPulse 2s ease-in-out infinite;
        }

        .header-section {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(139, 92, 246, 0.15) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 1rem;
            padding: 0.9rem 1rem;
            margin-bottom: 0.8rem;
            backdrop-filter: blur(10px);
        }

        .header-section h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-section p {
            color: #cbd5e1;
            margin-bottom: 0.7rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.6rem;
            margin-bottom: 0.8rem;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 0.9rem;
            padding: 0.7rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 10px 24px rgba(59, 130, 246, 0.15);
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.2) 100%);
            border-radius: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.35rem;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
            color: #60a5fa;
        }

        .stat-label {
            color: #94a3b8;
            font-size: 0.7rem;
            margin-bottom: 0.2rem;
            text-align: center;
        }

        .stat-value {
            font-size: 1.05rem;
            font-weight: 700;
            text-align: center;
            color: #f1f5f9;
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 0.75rem;
            margin-bottom: 0.8rem;
        }

        .room-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 0.95rem;
            padding: 0.85rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .room-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.8), rgba(139, 92, 246, 0.6), transparent);
        }

        .room-card:hover {
            transform: translateY(-4px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 14px 34px rgba(59, 130, 246, 0.12);
        }

        .room-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.85rem;
            padding-bottom: 0.7rem;
            border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        }

        .room-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.42rem 0.72rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.15) 100%);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 0.7rem;
            color: #6ee7b7;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .status-badge::before {
            content: '';
            width: 7px;
            height: 7px;
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

        .room-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.65rem;
            margin-bottom: 0.9rem;
        }

        .stat-item {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 0.85rem;
            padding: 0.7rem;
            border: 1px solid rgba(59, 130, 246, 0.15);
        }

        .stat-item-label {
            color: #94a3b8;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.35rem;
        }

        .stat-item-value {
            font-size: 1.05rem;
            font-weight: 700;
            color: #f1f5f9;
            display: flex;
            align-items: baseline;
            gap: 0.2rem;
        }

        .stat-item-unit {
            font-size: 0.8rem;
            color: #64748b;
        }

        .chart-container {
            position: relative;
            height: 170px;
            margin-top: 0.8rem;
        }

        .logout-btn {
            width: 100%;
            padding: 0.875rem 1rem;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.3) 0%, rgba(219, 39, 39, 0.2) 100%);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 1rem;
            color: #fca5a5;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.5) 0%, rgba(219, 39, 39, 0.4) 100%);
            border-color: rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            transform: translateY(-2px);
        }

        .info-box {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.08) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 1.5rem;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            backdrop-filter: blur(10px);
        }

        .info-box-icon {
            width: 24px;
            height: 24px;
            color: #60a5fa;
            flex-shrink: 0;
            margin-top: 0.25rem;
        }

        .info-box-content h3 {
            color: #f1f5f9;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .info-box-content p {
            color: #cbd5e1;
            font-size: 0.875rem;
        }

        /* SmarthCost Colorful Text Styles */
        .smarthcost-title {
            display: flex;
            gap: 0.3rem;
            font-size: 1.6rem;
            font-weight: 900;
            font-family: 'Poppins', 'Segoe UI', 'Arial Black', Arial, sans-serif;
            letter-spacing: 0.15em;
            padding: 0.75rem 1.5rem;
            border-radius: 1.25rem;
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .smarthcost-title span {
            display: inline-block;
            font-weight: 950;
            min-width: 1.5rem;
            text-align: center;
            position: relative;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            animation: slideInFromLeft 0.8s ease-out forwards;
        }

        .smarthcost-title span:nth-child(1) {
            animation-delay: 0s;
        }

        .smarthcost-title span:nth-child(2) {
            animation-delay: 0.15s;
        }

        .smarthcost-title span:nth-child(3) {
            animation-delay: 0.3s;
        }

        .smarthcost-title span:nth-child(4) {
            animation-delay: 0.45s;
        }

        .smarthcost-title span:nth-child(5) {
            animation-delay: 0.6s;
        }

        .smarthcost-title span:nth-child(6) {
            animation-delay: 0.75s;
        }

        .smarthcost-title span:nth-child(7) {
            animation-delay: 0.9s;
        }

        .smarthcost-title span:nth-child(8) {
            animation-delay: 1.05s;
        }

        .smarthcost-title span:nth-child(9) {
            animation-delay: 1.2s;
        }

        .smarthcost-title span:nth-child(10) {
            animation-delay: 1.35s;
        }

        .letter-s {
            color: #ff1493;
        }

        .letter-m {
            color: #ff6b35;
        }

        .letter-a {
            color: #ffa500;
        }

        .letter-r {
            color: #ffd700;
        }

        .letter-t {
            color: #00ff00;
        }

        .letter-h {
            color: #00bfff;
        }

        .letter-c {
            color: #0099ff;
        }

        .letter-o {
            color: #da70d6;
        }

        .letter-s2 {
            color: #ff1493;
        }

        .letter-t2 {
            color: #ffa500;
        }

        @keyframes slideInFromLeft {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
        }

        opacity: 0.9;
        }
        }

        @media (max-width: 1024px) {
            .rooms-grid {
                grid-template-columns: 1fr;
            }

            .page-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .page-layout {
                padding: 0.75rem;
                gap: 0.75rem;
            }

            .page-sidebar {
                padding: 1.25rem;
            }

            .page-main {
                padding: 1.25rem;
            }

            .header-section {
                padding: 1rem;
                margin-bottom: 1rem;
                border-radius: 1rem;
            }

            .header-section h2 {
                font-size: 1.2rem;
                margin-bottom: 0.2rem;
            }

            .header-section p {
                font-size: 0.75rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .stat-card {
                padding: 0.875rem;
                border-radius: 0.875rem;
            }

            .stat-label {
                font-size: 0.7rem;
                margin-bottom: 0.2rem;
            }

            .stat-value {
                font-size: 1.25rem;
            }

            .stat-icon {
                width: 36px;
                height: 36px;
                margin: 0 auto 0.35rem;
            }

            .rooms-grid {
                gap: 0.75rem;
            }

            .room-card {
                padding: 1rem;
                border-radius: 1rem;
            }

            .room-header {
                margin-bottom: 0.75rem;
            }

            .room-title {
                font-size: 1rem;
            }

            .room-stats {
                gap: 0.5rem;
            }

            .stat-item {
                padding: 0.75rem;
            }

            .stat-item-label {
                font-size: 0.7rem;
            }

            .stat-item-value {
                font-size: 1rem;
            }

            .stat-item-unit {
                font-size: 0.7rem;
            }

            .sidebar-icon {
                width: 44px;
                height: 44px;
            }

            .sidebar-header {
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                gap: 0.75rem;
            }

            .sidebar-header h1 {
                font-size: 1.1rem;
                line-height: 1.2;
            }

            .sidebar-header p {
                font-size: 0.7rem;
                line-height: 1.1;
            }

            .nav-link {
                padding: 0.625rem 0.75rem;
                margin-bottom: 0.25rem;
                font-size: 0.875rem;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .page-layout {
                padding: 0.5rem;
                gap: 0.5rem;
            }

            .page-sidebar {
                padding: 1rem;
                border-radius: 1rem;
            }

            .page-main {
                padding: 1rem;
                border-radius: 1rem;
            }

            .header-section {
                padding: 0.875rem;
                margin-bottom: 0.75rem;
                border-radius: 0.875rem;
            }

            .header-section h2 {
                font-size: 1rem;
                margin-bottom: 0.15rem;
            }

            .header-section p {
                font-size: 0.7rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.4rem;
                margin-bottom: 0.75rem;
            }

            .stat-card {
                padding: 0.75rem;
                border-radius: 0.75rem;
            }

            .stat-label {
                font-size: 0.65rem;
                margin-bottom: 0.15rem;
            }

            .stat-value {
                font-size: 1.1rem;
            }

            .stat-icon {
                width: 32px;
                height: 32px;
                margin: 0 auto 0.3rem;
            }

            .rooms-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .room-card {
                padding: 0.875rem;
            }

            .room-stats {
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem;
            }

            .stat-item {
                padding: 0.625rem;
            }

            .sidebar-header {
                gap: 0.5rem;
                margin-bottom: 0.75rem;
                padding-bottom: 0.75rem;
            }

            .nav-link {
                padding: 0.5rem 0.625rem;
                font-size: 0.8rem;
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
                            <path d="M13 2H3v20h18V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                            <path d="M9 13h6M9 17h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">SmarthCost</h1>
                        <p class="text-sm text-slate-400">Administrator</p>
                    </div>
                </div>

                @if (isset($room['monthly']) && is_array($room['monthly']))
                    <div style="margin-top:0.5rem; margin-bottom:0.5rem; color:#cbd5e1; font-size:0.9rem;">
                        <strong>Bulan:</strong> {{ $room['monthly']['month'] ?? '—' }}
                        &nbsp; • &nbsp;
                        <strong>Estimasi:</strong>
                        <span style="font-weight:700;">Rp
                            {{ $room['monthly']['tagihan']['total_tagihan'] ?? '—' }}</span>
                    </div>
                @endif
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.history') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <polyline points="19 12 12 19 5 12"></polyline>
                            </svg>
                        </span>
                        Payment History
                    </a>
                    <a href="{{ route('admin.reports') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="13" x2="12" y2="17"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                        </span>
                        Laporan
                    </a>
                    <a href="{{ route('admin.settings') }}" class="nav-link">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="1"></circle>
                                <path
                                    d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24">
                                </path>
                            </svg>
                        </span>
                        Settings
                    </a>
                </nav>
            </div>

            <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4">
                <p class="text-sm font-semibold text-slate-300">admin@gmail.com</p>
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width: 16px; height: 16px;">
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
            <!-- Header -->
            <div class="header-section">
                <p class="text-sm uppercase tracking-widest text-slate-400">SmarthCost Admin</p>
                <h2>Monitoring Listrik Realtime</h2>
                <p>Pantau penggunaan listrik 4 kamar dengan data yang diperbarui setiap 10 detik</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2H3v20h18V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                    <div class="stat-label">Total Kamar</div>
                    <div id="summary-total-rooms" class="stat-value">{{ $totalRooms ?? 0 }}</div>
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
                    <div class="stat-label">Total Daya</div>
                    <div id="summary-total-power" class="stat-value">{{ number_format($totalPower, 0, ',', '.') }} W
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="2" x2="12" y2="22"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="stat-label">Tagihan Bulan Ini</div>
                    <div id="summary-total-bill" class="stat-value">Rp {{ number_format($totalBill, 0, ',', '.') }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <div class="stat-label">Kamar Aktif</div>
                    <div id="summary-active-rooms" class="stat-value">{{ $activeRooms ?? 0 }}/{{ $totalRooms ?? 0 }}
                    </div>
                </div>
            </div>

            <!-- Room Cards with Charts -->
            <div class="rooms-grid">
                @forelse ($rooms as $index => $room)
                    <div class="room-card">
                        <div class="room-header">
                            <h3 class="room-title">{{ $room['name'] }}</h3>
                            <div class="status-badge {{ strtolower($room['status'] ?? 'offline') }}">
                                {{ $room['status'] ?? 'Offline' }}</div>
                        </div>

                        <div class="room-stats">
                            <div class="stat-item">
                                <div class="stat-item-label">Tegangan</div>
                                <div class="stat-item-value">
                                    <span class="stat-item-number">{{ $room['voltage'] }}</span>
                                    <span class="stat-item-unit">V</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-item-label">Arus</div>
                                <div class="stat-item-value">
                                    <span class="stat-item-number">{{ $room['current'] }}</span>
                                    <span class="stat-item-unit">A</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-item-label">Daya</div>
                                <div class="stat-item-value">
                                    <span class="stat-item-number">{{ $room['power'] }}</span>
                                    <span class="stat-item-unit">W</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-item-label">Tagihan</div>
                                <div class="stat-item-value">
                                    <span class="stat-item-unit">Rp</span>
                                    <span class="stat-item-number">{{ $room['bill'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="chart-container">
                            <canvas id="chart-{{ $index }}"></canvas>
                        </div>
                        <input type="hidden" class="room-user-id" value="{{ $room['user_id'] ?? '' }}">
                        <input type="hidden" class="room-number" value="{{ $index + 1 }}">
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-slate-400">Tidak ada data kamar</p>
                    </div>
                @endforelse
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <svg class="info-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <div class="info-box-content">
                    <h3>Data Real-Time</h3>
                    <p>Data diperbarui setiap 10 detik untuk memberikan informasi monitoring yang akurat dan terkini.
                    </p>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Chart configurations with professional color palette
        const chartConfigs = [{
                label: 'Kamar 1',
                borderColor: '#3b82f6',
                fillColor: 'rgba(59, 130, 246, 0.2)',
                pointColor: '#60a5fa'
            },
            {
                label: 'Kamar 2',
                borderColor: '#10b981',
                fillColor: 'rgba(16, 185, 129, 0.2)',
                pointColor: '#34d399'
            },
            {
                label: 'Kamar 3',
                borderColor: '#f59e0b',
                fillColor: 'rgba(245, 158, 11, 0.2)',
                pointColor: '#fbbf24'
            },
            {
                label: 'Kamar 4',
                borderColor: '#8b5cf6',
                fillColor: 'rgba(139, 92, 246, 0.2)',
                pointColor: '#a78bfa'
            }
        ];

        // Initialize charts for each room with enhanced styling
        document.querySelectorAll('canvas[id^="chart-"]').forEach((canvas, index) => {
            const config = chartConfigs[index] || chartConfigs[0];
            const ctx = canvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, config.fillColor);
            gradient.addColorStop(1, 'rgba(15, 23, 42, 0.05)');

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: ['00:00', '06:00', '12:00', '18:00', '23:59'],
                    datasets: [{
                        label: 'Daya (W)',
                        data: [2200 + Math.random() * 1000, 3500 + Math.random() * 1000, 4200 + Math
                            .random() * 1000, 3800 + Math.random() * 1000, 2500 + Math
                            .random() * 1000
                        ],
                        borderColor: config.borderColor,
                        backgroundColor: gradient,
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: config.pointColor,
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
                                color: 'rgba(59, 130, 246, 0.1)',
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
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 12,
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
        });

        // Replace full-page reload with targeted polling per room
        async function fetchRoomData(userId, roomId) {
            if (!userId && !roomId) return null;
            try {
                let url = '/api/billing/monitoring';
                const params = [];
                if (userId) params.push('user_id=' + encodeURIComponent(userId));
                else if (roomId) params.push('room_id=' + encodeURIComponent(roomId));
                if (params.length) url += '?' + params.join('&');

                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'include',
                    cache: 'no-store'
                });
                if (!res.ok) {
                    console.warn('fetchRoomData auth failed', res.status, res.statusText);
                    return null;
                }
                const json = await res.json();
                return json.data ?? null;
            } catch (e) {
                console.warn('fetchRoomData error', e);
                return null;
            }
        }

        // Poll each room every 10 seconds and update DOM values
        async function pollRooms() {
            document.querySelectorAll('.room-card').forEach(async (card, index) => {
                const userIdInput = card.querySelector('.room-user-id');
                const userId = userIdInput ? userIdInput.value : null;
                const roomNumInput = card.querySelector('.room-number');
                const roomNum = roomNumInput ? roomNumInput.value : null;
                if (!userId && !roomNum) return;
                const data = await fetchRoomData(userId, roomNum);
                if (!data) return;
                const arus = data.arus ?? {};
                const daya = data.daya ?? {};
                const tagihan = data.tagihan ?? {};

                // Update stat number spans inside this card
                card.querySelectorAll('.stat-item').forEach(el => {
                    const label = el.querySelector('.stat-item-label')?.textContent?.trim()
                        ?.toLowerCase();
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

                const statusBadge = card.querySelector('.status-badge');
                if (statusBadge && data.status) {
                    statusBadge.textContent = data.status;
                    statusBadge.classList.remove('online', 'offline');
                    statusBadge.classList.add(data.status.toLowerCase());
                }
            });
        }

        // Start polling immediately and every 10s
        pollRooms();
        setInterval(pollRooms, 10000);

        function getRoomValue(card, labelText) {
            const items = card.querySelectorAll('.stat-item');
            for (const item of items) {
                const label = item.querySelector('.stat-item-label')?.textContent?.trim().toLowerCase();
                if (!label) continue;
                if (label.includes(labelText.toLowerCase())) {
                    return item.querySelector('.stat-item-number')?.textContent || '';
                }
            }
            return '';
        }

        function updateSummaryTotals() {
            const roomCards = document.querySelectorAll('.room-card');
            let totalPower = 0;
            let totalBill = 0;
            let activeRooms = 0;
            let totalRooms = roomCards.length;

            roomCards.forEach(card => {
                const statusBadge = card.querySelector('.status-badge');
                const powerValue = getRoomValue(card, 'daya');
                const billValue = getRoomValue(card, 'tagihan');

                if (statusBadge && statusBadge.textContent.trim().toLowerCase() === 'online') {
                    activeRooms++;
                }

                if (powerValue) {
                    const cleanedPower = parseFloat(powerValue.replace(/[^0-9\.]/g, ''));
                    if (!isNaN(cleanedPower)) totalPower += cleanedPower;
                }
                if (billValue) {
                    const cleanedBill = parseFloat(billValue.replace(/[^0-9\.]/g, ''));
                    if (!isNaN(cleanedBill)) totalBill += cleanedBill;
                }
            });

            document.getElementById('summary-total-rooms').textContent = totalRooms;
            document.getElementById('summary-total-power').textContent = totalPower.toLocaleString('id-ID') + ' W';
            document.getElementById('summary-total-bill').textContent = 'Rp ' + totalBill.toLocaleString('id-ID');
            document.getElementById('summary-active-rooms').textContent = activeRooms + '/' + totalRooms;
        }

        setInterval(updateSummaryTotals, 10000);
        updateSummaryTotals();
    </script>
</body>

</html>
