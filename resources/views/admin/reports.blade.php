<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan - SmarthCost Admin</title>
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
        }

        .header-section {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(139, 92, 246, 0.15) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 1.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .header-section h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-section p {
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .form-section {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 1.5rem;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 0.5rem;
        }

        .form-group .description {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .room-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .room-checkbox {
            position: relative;
        }

        .room-checkbox input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .room-checkbox label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(59, 130, 246, 0.1);
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
        }

        .room-checkbox input[type="checkbox"]:checked+label {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.2) 100%);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .checkbox-icon {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(96, 165, 250, 0.5);
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .room-checkbox input[type="checkbox"]:checked+label .checkbox-icon {
            background: #60a5fa;
            border-color: #60a5fa;
        }

        .room-checkbox input[type="checkbox"]:checked+label .checkbox-icon::after {
            content: '✓';
            color: white;
            font-weight: bold;
            font-size: 0.875rem;
        }

        .room-info {
            flex: 1;
        }

        .room-name {
            color: #f1f5f9;
            font-weight: 600;
        }

        .room-users {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.6) 0%, rgba(139, 92, 246, 0.5) 100%);
            color: #f1f5f9;
            border: 1px solid rgba(59, 130, 246, 0.5);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.8) 0%, rgba(139, 92, 246, 0.7) 100%);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: transparent;
            color: #cbd5e1;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .loading {
            display: none;
        }

        .loading.active {
            display: inline;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .result-section {
            display: none;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 1.5rem;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-top: 2rem;
        }

        .result-section.active {
            display: block;
        }

        .result-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        }

        .result-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .result-icon.success {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .result-icon.success svg {
            color: #6ee7b7;
        }

        .result-icon.error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .result-icon.error svg {
            color: #fca5a5;
        }

        .result-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .result-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .result-stat {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 1rem;
            padding: 1rem;
        }

        .result-stat-label {
            color: #94a3b8;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .result-stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .result-details {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 1rem;
        }

        .result-detail-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem;
            background: rgba(59, 130, 246, 0.05);
            border-left: 3px solid rgba(59, 130, 246, 0.3);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .result-detail-item.success {
            border-left-color: rgba(16, 185, 129, 0.5);
        }

        .result-detail-item.failed {
            border-left-color: rgba(239, 68, 68, 0.5);
        }

        .result-detail-user {
            flex: 1;
        }

        .result-detail-user-name {
            color: #f1f5f9;
            font-weight: 600;
        }

        .result-detail-user-msg {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .result-detail-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.75rem;
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 0.5rem;
            color: #6ee7b7;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge.failed {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        @media (max-width: 1024px) {
            .page-layout {
                grid-template-columns: 1fr;
            }

            .room-selection {
                grid-template-columns: 1fr;
            }

            .result-stats {
                grid-template-columns: 1fr;
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

            .form-section {
                padding: 1.5rem;
            }

            .button-group {
                flex-direction: column;
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

                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Dashboard
                    </a>
                    <a href="#" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 5 7 13 17 13"></polyline>
                        </svg>
                        Data Kamar
                    </a>
                    <a href="#" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <polyline points="19 12 12 19 5 12"></polyline>
                        </svg>
                        Riwayat
                    </a>
                    <a href="#" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="2" x2="12" y2="22"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        Tagihan
                    </a>
                    <a href="{{ route('admin.reports') }}" class="nav-link active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="13" x2="12" y2="17"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                        Laporan
                    </a>
                    <a href="#" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="1"></circle>
                            <path
                                d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24">
                            </path>
                        </svg>
                        Pengaturan
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
                <h2>Laporan Pengiriman Tagihan</h2>
                <p>Kirim notifikasi tagihan listrik ke pengguna via WhatsApp</p>
            </div>

            <!-- Form Section -->
            <form id="billingForm" class="form-section">
                @csrf
                <div class="form-group">
                    <label>Pilih Kamar untuk Pengiriman Notifikasi</label>
                    <p class="description">Notifikasi tagihan listrik akan dikirim ke semua pengguna di kamar yang
                        dipilih</p>

                    <div class="room-selection">
                        @forelse ($rooms as $roomId => $room)
                            <div class="room-checkbox">
                                <input type="checkbox" id="room_{{ $roomId }}" name="room_ids[]"
                                    value="{{ $roomId }}" data-room-name="{{ $room['name'] }}">
                                <label for="room_{{ $roomId }}">
                                    <div class="checkbox-icon"></div>
                                    <div class="room-info">
                                        <div class="room-name">{{ $room['name'] }}</div>
                                        <div class="room-users">
                                            @php
                                                $userCount = $users->where('room', $roomId)->count();
                                            @endphp
                                            {{ $userCount }} pengguna
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @empty
                            <p class="text-slate-400">Tidak ada kamar tersedia</p>
                        @endforelse
                    </div>
                </div>

                <div class="form-group">
                    <label>Ringkasan</label>
                    <div class="room-selection">
                        <div
                            style="flex: 1; padding: 1rem; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 1rem;">
                            <div class="result-stat-label">Total Pengguna Terpilih</div>
                            <div class="result-stat-value" id="totalUsers">0</div>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary" id="sendBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width: 20px; height: 20px;">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <path d="M20 8v6M23 11h-6"></path>
                        </svg>
                        Kirim Notifikasi
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width: 20px; height: 20px;">
                            <path d="M19 12H5M12 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </form>

            <!-- Result Section -->
            <div class="result-section" id="resultSection">
                <div class="result-header">
                    <div class="result-icon success" id="resultIcon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width: 24px; height: 24px;">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div class="result-title" id="resultTitle">Notifikasi Dikirim</div>
                        <p class="text-slate-400" id="resultMessage"></p>
                    </div>
                </div>

                <div class="result-stats">
                    <div class="result-stat">
                        <div class="result-stat-label">Berhasil</div>
                        <div class="result-stat-value" id="successCount">0</div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-label">Gagal</div>
                        <div class="result-stat-value" id="failedCount">0</div>
                    </div>
                </div>

                <div>
                    <h3 style="color: #f1f5f9; font-weight: 600; margin-bottom: 1rem;">Detail Pengiriman</h3>
                    <div class="result-details" id="resultDetails">
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const form = document.getElementById('billingForm');
        const sendBtn = document.getElementById('sendBtn');
        const resultSection = document.getElementById('resultSection');
        const checkboxes = document.querySelectorAll('input[name="room_ids[]"]');
        const totalUsersSpan = document.getElementById('totalUsers');

        // Update total users count
        function updateTotalUsers() {
            const selectedRooms = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => parseInt(cb.value));

            let total = 0;
            selectedRooms.forEach(roomId => {
                const roomCheckbox = document.querySelector(`input[value="${roomId}"]`);
                const roomLabel = roomCheckbox.nextElementSibling;
                const userCountText = roomLabel.querySelector('.room-users').textContent;
                const count = parseInt(userCountText);
                total += count;
            });

            totalUsersSpan.textContent = total;
        }

        // Add event listeners to checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotalUsers);
        });

        // Form submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const selectedRooms = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => parseInt(cb.value));

            if (selectedRooms.length === 0) {
                alert('Pilih minimal satu kamar');
                return;
            }

            // Show loading state
            sendBtn.disabled = true;
            const originalText = sendBtn.innerHTML;
            sendBtn.innerHTML =
                '<svg viewBox="0 0 24 24" style="width: 20px; height: 20px; animation: spin 1s linear infinite; stroke: currentColor; stroke-width: 2; fill: none;"><circle cx="12" cy="12" r="10"></circle></svg> Mengirim...';

            try {
                const response = await fetch('{{ route('admin.reports.send-billing') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({
                        room_ids: selectedRooms,
                    }),
                });

                // Handle non-JSON responses (HTML error pages, redirects)
                const contentType = response.headers.get('content-type') || '';
                let data;

                if (contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    showErrorResult('Server returned non-JSON response: ' + text);
                    return;
                }

                if (data.success) {
                    showSuccessResult(data.data);
                } else {
                    showErrorResult(data.message || JSON.stringify(data));
                }
            } catch (error) {
                showErrorResult('Terjadi kesalahan: ' + error.message);
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalText;
            }
        });

        function showSuccessResult(result) {
            document.getElementById('resultIcon').className = 'result-icon success';
            document.getElementById('resultTitle').textContent = 'Notifikasi Berhasil Dikirim';
            // Prefer backend-provided cumulative total within 24 hours when available
            const totalSent = (result.total_sent_last_24h !== undefined && result.total_sent_last_24h !== null)
                ? result.total_sent_last_24h
                : result.success;
            document.getElementById('resultMessage').textContent =
                `${totalSent} notifikasi berhasil dikirim`;
            // Show cumulative 'Berhasil' when available, else per-request successes
            document.getElementById('successCount').textContent = totalSent;
            document.getElementById('failedCount').textContent = result.failed;

            const detailsHtml = result.details.map(detail => `
                <div class="result-detail-item ${detail.status}">
                    <div class="result-detail-user">
                        <div class="result-detail-user-name">${detail.user}</div>
                        <div class="result-detail-user-msg">${detail.message}</div>
                    </div>
                    <div class="result-detail-status">
                        <div class="status-badge ${detail.status}">
                            ${detail.status === 'success' ? '✓' : '✗'} ${detail.status === 'success' ? 'Berhasil' : 'Gagal'}
                        </div>
                    </div>
                </div>
            `).join('');

            document.getElementById('resultDetails').innerHTML = detailsHtml;
            resultSection.classList.add('active');
        }

        function showErrorResult(message) {
            document.getElementById('resultIcon').className = 'result-icon error';
            document.getElementById('resultTitle').textContent = 'Terjadi Kesalahan';
            document.getElementById('resultMessage').textContent = message;
            document.getElementById('successCount').textContent = '0';
            document.getElementById('failedCount').textContent = '1';
            document.getElementById('resultDetails').innerHTML =
                `<div class="result-detail-item failed">
                    <div class="result-detail-user">
                        <div class="result-detail-user-name">Error</div>
                        <div class="result-detail-user-msg">${message}</div>
                    </div>
                </div>`;
            resultSection.classList.add('active');
        }
    </script>
</body>

</html>
