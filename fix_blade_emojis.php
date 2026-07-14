<?php
$filePath = __DIR__ . '/resources/views/login.blade.php';

// Read file in binary mode to preserve exact bytes
$content = file_get_contents($filePath);

// Define hex replacements (corrupted UTF-8 patterns to correct UTF-8)
$replacements = [
    // Corrupted bytes to correct UTF-8
    "\xc3\xa2\xcb\x9c\xe2\x80\xac\xef\xb8" => "☀️",      // â˜€ï¸ -> ☀️
    "\xc3\xa2\xcb\x9c\xe2\x80\xac" => "☀️",                 // â˜€ -> ☀️  
    "\xc3\xa2\xcb\x9c\xcb\x9e" => "🌙",                    // ðŸŒ™ (partial)
    "\xef\xb8\x8c\xe2\x84\xa2" => "🌙",                    // variant
    "\xf0\x9f\x8c\x99" => "🌙",                             // ðŸŒ™ -> 🌙
    "\xf0\x9f\x92\xa4" => "👤",                             // ðŸ'¤ -> 👤
    "\xc3\xa2\x86\xb6" => "↶",                              // â†¶ -> ↶
    "\xc3\xa2\xcb\x9c\xc5\xbd\xef\xb8" => "☎️",             // â˜Žï¸ -> ☎️
    "\xf0\x9f\x92\xac" => "💬",                             // ðŸ'¬ -> 💬
    "\xf0\x9f\x93\x8b" => "📋",                             // ðŸ"‹ -> 📋
    "\xf0\x9f\x93\xba" => "📺",                             // ðŸ"º -> 📺
    "\xf0\x9f\x9b\x8f\xef\xb8" => "🛏️",                    // ðŸ›ï¸ -> 🛏️
    "\xf0\x9f\x9a\xbd" => "🚽",                             // ðŸš½ -> 🚽
    "\xf0\x9f\x9a\xb0" => "🚰",                             // ðŸš° -> 🚰
    "\xf0\x9f\x93\xa1" => "📡",                             // ðŸ"¡ -> 📡
    "\xf0\x9f\x85\xbf\xef\xb8" => "🅿️",                    // ðŸ…¿ï¸ -> 🅿️
    "\xc3\xa2\x84\x84\xef\xb8" => "❄️",                     // â„ï¸ -> ❄️
    "\xc3\x83\xe2\x80\x94" => "×",                          // Ã— -> ×
    "\xf0\x9f\x9b\xa1\xef\xb8" => "🛡️",                    // ðŸ›¡ï¸ -> 🛡️
    "\xf0\x9f\x9a\xaa" => "🚪",                             // ðŸšª -> 🚪
];

// Apply replacements
foreach ($replacements as $old => $new) {
    $content = str_replace($old, $new, $content);
}

// Write back
file_put_contents($filePath, $content);

echo "File fixed successfully!\n";
