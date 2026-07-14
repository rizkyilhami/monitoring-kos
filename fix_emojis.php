<?php
$file = 'resources/views/login.blade.php';
$content = file_get_contents($file);

// Replace corrupted emojis
$content = str_replace('â˜€ï¸', '☀️', $content);
$content = str_replace('ðŸŒ™', '🌙', $content);
$content = str_replace('ðŸ'¤', '👤', $content);

file_put_contents($file, $content);
echo "Fixed corrupted emojis\n";
?>
