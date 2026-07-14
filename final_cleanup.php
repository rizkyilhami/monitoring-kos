<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$content = file_get_contents($file, FILE_IGNORE_NEW_LINES);

if (!$content) {
    die("Cannot read file\n");
}

// Try many different patterns to catch all corrupted bytes
// These are common double-encoding artifacts
$replacements = array(
    // Pattern 1: Direct string patterns that show as corrupted
    'sun-icon">â˜€ï¸<' => 'sun-icon">☀️<',
    'sun-icon">' . chr(0xc3) . chr(0xa2) . chr(0xc2) . chr(0x98) . chr(0xc2) . chr(0x80) . chr(0xc3) . chr(0xaf) . chr(0xc2) . chr(0xb8) . '<' => 'sun-icon">☀️<',

    // For moon: ðŸŌ™
    'Mode Gelap</span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Kartu Login -->
                <div class="cards-grid grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- KARTU ADMIN -->
                    <div class="card-login" onclick="showLoginForm(\'admin\')">
                        <div class="icon-wrapper admin">☀️</div>
                        <h3 class="card-title">Login Admin</h3>
                        <p class="card-desc">Kelola sistem dan data kos</p>
                        <button class="btn-login btn-admin">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span>Login sebagai Admin</span>
                        </button>
                    </div>

                    <!-- KARTU USER -->
                    <div class="card-login" onclick="showLoginForm(\'user\')">
                        <div class="icon-wrapper user">👤</div>
                        <h3 class="card-title">Login User</h3>
                        <p class="card-desc">Akses info dan layanan kos</p>
                        <button class="btn-login btn-user">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span>Login sebagai User</span>
                        </button>
                    </div>
                </div>' => 'Mode Gelap</span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Kartu Login -->
                <div class="cards-grid grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- KARTU ADMIN -->
                    <div class="card-login" onclick="showLoginForm(\'admin\')">
                        <div class="icon-wrapper admin">👤</div>
                        <h3 class="card-title">Login Admin</h3>
                        <p class="card-desc">Kelola sistem dan data kos</p>
                        <button class="btn-login btn-admin">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span>Login sebagai Admin</span>
                        </button>
                    </div>

                    <!-- KARTU USER -->
                    <div class="card-login" onclick="showLoginForm(\'user\')">
                        <div class="icon-wrapper user">👤</div>
                        <h3 class="card-title">Login User</h3>
                        <p class="card-desc">Akses info dan layanan kos</p>
                        <button class="btn-login btn-user">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span>Login sebagai User</span>
                        </button>
                    </div>
                </div>',
);

foreach ($replacements as $search => $replace) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        echo "Replaced pattern\n";
    }
}

file_put_contents($file, $content);
echo "Done writing fixed content\n";
