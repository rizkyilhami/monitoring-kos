<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$data = file_get_contents($file);

// Try multiple possible encodings
$corrupted_patterns = array(
    "\xc3\xb0\xc2\x9f\xc2\x9b\xc2\xa1\xc3\xaf\xc2\xb8",  // ðŸ›¡ï¸
    "ðŸ›¡ï¸",  // String literal
);

$clean = "🛡️";

$found = false;
foreach ($corrupted_patterns as $pattern) {
    $count = 0;
    $data = str_replace($pattern, $clean, $data, $count);
    if ($count > 0) {
        $found = true;
        echo "Found and replaced $count instance(s)\n";
    }
}

if (!$found) {
    echo "Pattern not found. Trying regex...\n";
    // Try regex to match any weird character sequence before Admin Demo
    $data = preg_replace(
        '/<div style="font-size: 20px; margin-bottom: 8px;">.*?<\/div>[\s]*<div class="demo-btn-admin">Admin Demo<\/div>/',
        '<div style="font-size: 20px; margin-bottom: 8px;">🛡️</div>' . "\n" . '                            <div class="demo-btn-admin">Admin Demo</div>',
        $data
    );
    echo "Applied regex replacement\n";
}

file_put_contents($file, $data);
echo "Done!\n";
