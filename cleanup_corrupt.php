<?php
// Read the entire file
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$content = file_get_contents($file);

// Replace all corrupted emoji sequences with simple ASCII first to see what happens
// Then we can identify the exact byte patterns
$corrupted = [
    "\xc3\xa2\xc2\x98\xc2\x80\xc3\xaf\xc2\xb8",  // â˜€ï¸
    "â˜€ï¸",
    "\xc3\xb0\xc2\x9f\xc2\x8c\xc2\x99",          // ðŸŌ™
    "ðŸŌ™",
    "\xc3\xb0\xc2\x9f\xc2\x91\xc2\xa4",          // ðŸ'¤
    "ðŸ'¤",
    "\xc3\xa2\xc2\x86\xc2\xb6",                  // â†¶
    "â†¶",
    "\xc3\xa2\xc2\x98\xc2\x8e\xc3\xaf\xc2\xb8",  // â˜Žï¸
    "â˜Žï¸",
    "\xc3\xb0\xc2\x9f\xc2\x92\xc2\xac",          // ðŸ'¬
    "ðŸ'¬",
];

$clean = [
    "L",  // Will change to emoji via JavaScript
    "L",
    "M",  // Will change to emoji via JavaScript
    "M",
    "U",  // Will change to emoji via JavaScript
    "U",
    "B",  // Undo arrow
    "B",
    "P",  // Phone
    "P",
    "C",  // Chat
    "C",
];

$content = str_replace($corrupted, $clean, $content);
file_put_contents($file, $content, LOCK_EX);

echo "Replaced corrupted characters with clean ASCII\n";
echo "Total replacements in file\n";
