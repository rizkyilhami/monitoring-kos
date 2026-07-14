<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$content = file_get_contents($file);

// Replace corrupted emojis with clean ones - using simple string patterns
$replacements = array(
    'Mode Terang</span>' => 'Mode Terang</span>',  // Will be handled by regex below
    'Mode Gelap</span>' => 'Mode Gelap</span>',    // Will be handled by regex below
);

// Use regex to fix theme buttons - look for any character between > and < and replace with emoji
$content = preg_replace_callback(
    '/<span>([^<]*)<\/span>\s*<span>Mode Terang<\/span>/',
    function ($matches) {
        // Check if it looks like corrupted emoji
        if (strpos($matches[1], 'â˜€') !== false || strpos($matches[1], 'ðŸŒ™') !== false || strlen($matches[1]) > 4) {
            return '<span>☀️</span>' . "\n                                <span>Mode Terang</span>";
        }
        return $matches[0];
    },
    $content
);

$content = preg_replace_callback(
    '/<span>([^<]*)<\/span>\s*<span>Mode Gelap<\/span>/',
    function ($matches) {
        if (strlen($matches[1]) > 4 || preg_match('/[^a-zA-Z0-9]/', $matches[1])) {
            return '<span>🌙</span>' . "\n                                <span>Mode Gelap</span>";
        }
        return $matches[0];
    },
    $content
);

// Fix contact buttons - replace any span content that looks corrupted with correct emoji
$content = preg_replace_callback(
    '/<button class="contact-action-btn whatsapp"[^>]*>\\s*<span>([^<]*)<\/span>/',
    function ($matches) {
        if (strlen($matches[1]) > 3) {
            return '<button class="contact-action-btn whatsapp" onclick="openWhatsApp(\'081249471258\')">' . "\n                            <span>💬</span>";
        }
        return $matches[0];
    },
    $content
);

$content = preg_replace_callback(
    '/<button class="contact-action-btn copy"[^>]*>\\s*<span>([^<]*)<\/span>/',
    function ($matches) {
        if (strlen($matches[1]) > 3) {
            return '<button class="contact-action-btn copy" onclick="copyPhone(\'081249471258\')">' . "\n                            <span>📋</span>";
        }
        return $matches[0];
    },
    $content
);

file_put_contents($file, $content);
echo "Fixed remaining corrupted emojis!\n";
