#!/usr/bin/env php
<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';

// Read as binary
$content = file_get_contents($file);

if (!$content) {
    echo "Error: Cannot read file\n";
    exit(1);
}

$original_size = strlen($content);

// Define all corrupted emoji UTF-8 sequences and their clean replacements
$fixes = array(
    // Sun emoji corrupted sequences
    "\xc3\xa2\xc2\x98\xc2\x80\xc3\xaf\xc2\xb8" => "☀️",  // Corrupted sun

    // Moon emoji corrupted sequences
    "\xc3\xb0\xc2\x9f\xc2\x8c\xc2\x99" => "🌙",  // Corrupted moon

    // User emoji corrupted sequences
    "\xc3\xb0\xc2\x9f\xc2\x91\xc2\xa4" => "👤",  // Corrupted user

    // Undo arrow corrupted sequences
    "\xc3\xa2\xc2\x86\xc2\xb6" => "↶",  // Corrupted undo

    // Phone emoji corrupted sequences
    "\xc3\xa2\xc2\x98\xc2\x8e\xc3\xaf\xc2\xb8" => "☎️",  // Corrupted phone

    // Chat emoji corrupted sequences
    "\xc3\xb0\xc2\x9f\xc2\x92\xc2\xac" => "💬",  // Corrupted chat

    // Copy/clipboard emoji corrupted sequences
    "\xc3\xb0\xc2\x9f\xc2\x93\xc2\x8b" => "📋",  // Corrupted clipboard
);

$replaced = 0;
foreach ($fixes as $corrupted => $clean) {
    $count = 0;
    $content = str_replace($corrupted, $clean, $content, $count);
    if ($count > 0) {
        echo "Replaced $count instance(s) of corrupted emoji\n";
        $replaced += $count;
    }
}

// Write back
if (file_put_contents($file, $content) === false) {
    echo "Error: Cannot write file\n";
    exit(1);
}

$new_size = strlen($content);
echo "\nDone! File updated.\n";
echo "Size changed from $original_size to $new_size bytes\n";
echo "Total replacements: $replaced\n";
?>