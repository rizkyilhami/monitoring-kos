<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';

// Read file as binary
$data = file_get_contents($file);

// Define the exact corrupted byte sequences and their replacements
$changes = array(
    // Sun emoji in theme button (Mode Terang)
    "\xc3\xa2\xc2\x98\xc2\x80\xc3\xaf\xc2\xb8" => "☀️",  // â˜€ï¸ -> ☀️

    // Moon emoji in theme button (Mode Gelap)
    "\xc3\xb0\xc2\x9f\xc2\x8c\xc2\x99" => "🌙",  // ðŸŌ™ -> 🌙

    // Chat/message emoji in WhatsApp button
    "\xc3\xb0\xc2\x9f\xc2\x92\xc2\xac" => "💬",  // ðŸ'¬ -> 💬

    // Clipboard/copy emoji
    "\xc3\xb0\xc2\x9f\xc2\x93\xc2\x8b" => "📋",  // ðŸ"‹ -> 📋
);

$count = 0;
foreach ($changes as $from => $to) {
    $occurrences = 0;
    $data = str_replace($from, $to, $data, $occurrences);
    $count += $occurrences;
    if ($occurrences > 0) {
        echo "Replaced $occurrences instance(s) of one emoji\n";
    }
}

file_put_contents($file, $data);
echo "\nTotal: $count replacements\n";
echo "Done!\n";
