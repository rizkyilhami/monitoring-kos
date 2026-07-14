<?php
// Read file as binary
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$data = file_get_contents($file);

// Decode with error handling
if ($data === false) {
    echo "Failed to read file\n";
    exit(1);
}

// Replace corrupted sequences
// Match any non-ASCII byte sequence between opening and closing tags
$data = str_ireplace(
    array(
        "sun-icon\">ðŸ\"",
        "sun-icon\">â˜€ï¸",
        "user\">\xef\xbf\xbd<",  // Replacement character
    ),
    array(
        "sun-icon\">☀️",
        "sun-icon\">☀️",
        "user\">👤<",
    ),
    $data
);

// Write back
if (file_put_contents($file, $data) === false) {
    echo "Failed to write file\n";
} else {
    echo "Success\n";
}
