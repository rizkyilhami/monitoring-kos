<?php
$filePath = 'resources/views/login.blade.php';
$fileContent = file_get_contents($filePath);

// These are the actual UTF-8 sequences that appear corrupted
// UTF-8 double encoding of emojis
$corrupted = array(
    "\xc3\xa2\xc2\x98\xc2\x80\xc3\xaf\xc2\xb8",  // "â˜€ï¸" = corrupted sun
    "\xc3\xb0\xc2\x9f\xc2\x8c\xc2\x99",          // "ðŸŌ™" = corrupted moon  
    "\xc3\xb0\xc2\x9f\xc2\x91\xc2\xa4",          // "ðŸ'¤" = corrupted user
);

$clean = array(
    "☀️",  // Sun emoji
    "🌙",  // Moon emoji
    "👤",  // User emoji
);

$fileContent = str_replace($corrupted, $clean, $fileContent);
file_put_contents($filePath, $fileContent);
echo "Fixed emojis in login.blade.php\n";
