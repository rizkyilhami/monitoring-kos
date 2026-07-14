<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$data = file_get_contents($file);

// Fix the shield emoji that's corrupted
$data = str_replace("\xc3\xb0\xc2\x9f\xc2\x9b\xc2\xa1\xc3\xaf\xc2\xb8", "🛡️", $data);  // ðŸ›¡ï¸ -> 🛡️

file_put_contents($file, $data);
echo "Fixed Admin Demo button emoji!\n";
