<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';

// Read the entire file
$content = file_get_contents($file);

// Use regex to find and replace any content between > and < that looks like corrupted emojis
// and replace with clean emojis

// Pattern 1: sun-icon span
$content = preg_replace('/<span id="sun-icon">.*?<\/span>/', '<span id="sun-icon">☀️</span>', $content);

// Pattern 2: icon-wrapper user
$content = preg_replace('/<div class="icon-wrapper user">.*?<\/div>/', '<div class="icon-wrapper user">👤</div>', $content);

// Pattern 3: Mode Gelap button - replace first span inside it
$content = preg_replace('/<button class="theme-option" onclick="setTheme\(\'dark\'\)">.*?<span>.*?<\/span>/', '<button class="theme-option" onclick="setTheme(\'dark\')"><span>🌙</span>', $content);

// Pattern 4: Mode Terang button - replace first span
$content = preg_replace('/<button class="theme-option active" onclick="setTheme\(\'light\'\)">.*?<span>.*?<\/span>/', '<button class="theme-option active" onclick="setTheme(\'light\')"><span>☀️</span>', $content);

// Pattern 5: contact-icon
$content = preg_replace('/<div class="contact-icon">.*?<\/div>/', '<div class="contact-icon">☎️</div>', $content);

// Pattern 6: WhatsApp button span
$content = preg_replace('/<button class="contact-action-btn whatsapp".*?>.*?<span>.*?<\/span>/', '<button class="contact-action-btn whatsapp" onclick="openWhatsApp(\'081249471258\')"><span>💬</span>', $content);

// Pattern 7: Copy button span
$content = preg_replace('/<button class="contact-action-btn copy".*?>.*?<span>.*?<\/span>/', '<button class="contact-action-btn copy" onclick="copyPhone(\'081249471258\')"><span>📋</span>', $content);

// Pattern 8-15: Facility icons
$facilities = array(
    'AC' => '❄️',
    'TV' => '📺',
    'Kasur' => '🛏️',
    'WiFi' => '📡',
    'Parkiran' => '🅿️',
);

foreach ($facilities as $name => $emoji) {
    $pattern = '/<div class="facility-icon">.*?<\/div>[\s]*<div class="facility-name">' . preg_quote($name) . '<\/div>/';
    $replacement = '<div class="facility-icon">' . $emoji . '</div>' . "\n                                <div class=\"facility-name\">" . $name . '</div>';
    $content = preg_replace($pattern, $replacement, $content);
}

// Write back
file_put_contents($file, $content);

echo "File fixed with regex replacements!\n";
echo "New file size: " . strlen($content) . " bytes\n";
