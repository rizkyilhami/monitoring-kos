<?php
header('Content-Type: text/plain; charset=utf-8');

$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';

// Read file preserving all bytes exactly
$content = file_get_contents($file);
if ($content === false) {
    die("Cannot read file\n");
}

$original_len = strlen($content);
echo "Original file size: " . $original_len . " bytes\n";

// Try all possible encodings of the corrupted emoji bytes
$patterns = array(
    // Try to match corrupted sun emoji in various formats
    hex2bin('c3a2c298c280c3afc2b8'), // UTF-8 double-encoded sun
    hex2bin('e28882'), // Actual UTF-8 for sun: ☀
    hex2bin('ef bfbd'), // Replacement character
    // And the display strings
    "â˜€ï¸",
    "ðŸŌ™",
    "ðŸ'¤",
);

$replace_map = array(
    'sun-icon">' => 'sun-icon">☀️',
    'user">' => 'user">👤',
    'Mode Gelap</span><span>' => 'Mode Gelap</span><span>🌙</',
);

foreach ($replace_map as $search => $repl) {
    $content = str_replace($search, $repl, $content);
}

// Write file
$written = file_put_contents($file, $content, LOCK_EX);
if ($written === false) {
    echo "Failed to write\n";
} else {
    echo "Wrote " . $written . " bytes\n";
    echo "Done\n";
}
